<?php

declare(strict_types=1);

namespace App\Reports;

use App\Enums\Report\Type;
use App\Models\Activity;
use App\Models\Beneficiary;
use Illuminate\Contracts\Database\Query\Expression as ExpressionContract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Expression;
use Illuminate\Database\Query\JoinClause;
use Tpetry\QueryExpressions\Language\Alias;
use Tpetry\QueryExpressions\Operator\Comparison\Between;
use Tpetry\QueryExpressions\Operator\Comparison\Equal;
use Tpetry\QueryExpressions\Operator\Comparison\GreaterThanOrEqual;
use Tpetry\QueryExpressions\Value\Value;

class NurseActivityReport extends ReportFactory
{
    protected Type $type = Type::NURSE_ACTIVITY;

    protected function segmentByAge(string $value): ExpressionContract
    {
        return match ($value) {
            'total' => new Equal('age', 'age'),
            'VCV_01' => new Equal('age', new Value(0)),
            'VCV_02' => new Between('age', new Value(1), new Value(4)),
            'VCV_03' => new Between('age', new Value(5), new Value(13)),
            'VCV_04' => new Between('age', new Value(14), new Value(17)),
            'VCV_05' => new Between('age', new Value(18), new Value(64)),
            'VCV_06' => new GreaterThanOrEqual('age', new Value(65)),
            default => new Value($value),
        };
    }

    protected function segmentByGender(string $value): ExpressionContract
    {
        return new Equal('gender', match ($value) {
            'total' => 'gender',
            default => new Value($value),
        });
    }

    protected function queryBeneficiaries(array $values, array $columns): array
    {
        $indicators = collect($values)
            ->reject('total')
            ->values();

        return $this->runQueryFor(
            Beneficiary::class,
            'created_at',
            fn (Builder $query) => $query
                ->select($columns)
                ->when(
                    $this->report->segments->has('age'),
                    function (Builder $query) {
                        $query->fromSub(function ($query) {
                            $query
                                ->select('*')
                                ->selectRaw('TIMESTAMPDIFF(YEAR, date_of_birth, ?) AS age', [$this->report->date_from->toDateString()])
                                ->from('beneficiaries');
                        }, 'beneficiaries');
                    }
                )
                ->when(
                    $indicators->isNotEmpty(),
                    function (Builder $query) use ($indicators) {
                        $query->whereIn('status', $indicators->all())
                            ->selectRaw('IF(GROUPING(status), "total", status) AS status')
                            ->groupByRaw('status WITH ROLLUP');
                    },
                    function (Builder $query) {
                        $query->addSelect(new Alias(new Value('total'), 'status'));
                    }
                ),
            'status'
        );
    }

    protected function queryGeneralRecord(array $values, array $columns): array
    {
        $indicators = collect($values);

        return $this->runQueryFor(
            Activity::class,
            'activity_log.created_at',
            fn (Builder $query) => $query
                ->select($columns)
                ->withoutGlobalScope('latest')
                ->inLog('vulnerabilities')
                ->when(
                    auth()->user()->isNurse(),
                    fn (Builder $query) => $query->where('nurse_id', auth()->id())
                )
                ->fromSub(
                    function ($query) {
                        $query
                            ->select(['activity_log.*', 'beneficiaries.nurse_id', 'beneficiaries.gender'])
                            ->selectRaw('TIMESTAMPDIFF(YEAR, date_of_birth, ?) AS age', [$this->report->date_from->toDateString()])
                            ->from('activity_log')
                            ->leftJoin('beneficiaries', function (JoinClause $join) {
                                $join->on('beneficiaries.id', '=', 'activity_log.subject_id')
                                    ->where('activity_log.subject_type', 'beneficiary');
                            });
                    },
                    'activity_log'
                )
                ->when(
                    $indicators->isNotEmpty(),
                    function (Builder $query) use ($indicators) {
                        $cases = $indicators
                            ->mapWithKeys(fn (string $indicator) => [
                                $indicator => match ($indicator) {
                                    'adult_no_medicosocial' => '(age BETWEEN 18 AND 65) AND JSON_LENGTH(properties) = 0',
                                    'adult_with_cronic_illness' => '(age BETWEEN 18 AND 65) AND (JSON_CONTAINS(properties, \'"VSG_01"\') OR JSON_CONTAINS(properties, \'"VSG_BPO"\') OR JSON_CONTAINS(properties, \'"VSG_HEP"\') OR JSON_CONTAINS(properties, \'"VSG_IR"\'))',
                                    'adult_with_disabilities' => '(age BETWEEN 18 AND 65) AND (JSON_CONTAINS(properties, \'"VDH_01"\') OR JSON_CONTAINS(properties, \'"VDH_02"\'))',
                                    'adult_without_family' => '(age BETWEEN 18 AND 65) AND JSON_CONTAINS(properties, \'"VFA_01"\')',
                                    'familiy_with_domestic_violence_case' => 'JSON_CONTAINS(properties, \'"VFV_03"\')',
                                    'woman_fertile_age' => '(age BETWEEN 18 AND 45) AND gender = "female"',
                                    'woman_postpartum' => 'JSON_CONTAINS(properties, \'"VGR_02"\') or JSON_CONTAINS(properties, \'"VGR_08"\')',
                                    'underage_mother' => '(age < 18) AND JSON_CONTAINS(properties, \'"VGR_03"\')',
                                    'family_planning' => null,
                                    'person_without_gp' => 'JSON_CONTAINS(properties, \'"VSA_02"\')',
                                    'elderly' => '(age >= 65)',
                                    'elderly_without_family' => '(age >= 65) AND JSON_CONTAINS(properties, \'"VFA_01"\')',
                                    'elderly_with_cronic_illness' => '(age >= 65) AND (JSON_CONTAINS(properties, \'"VSG_01"\') OR JSON_CONTAINS(properties, \'"VSG_BPO"\') OR JSON_CONTAINS(properties, \'"VSG_HEP"\') OR JSON_CONTAINS(properties, \'"VSG_IR"\'))',
                                    'elderly_with_disabilities' => '(age >= 65) AND (JSON_CONTAINS(properties, \'"VDH_01"\') OR JSON_CONTAINS(properties, \'"VDH_02"\'))',
                                }])
                            ->filter()
                            ->map(fn (string $filter, string $indicator) => "WHEN ({$filter}) THEN \"{$indicator}\"")
                            ->implode('');

                        $query->selectRaw(new Alias(new Expression("CASE {$cases} END"), 'indicator'))
                            ->groupBy('indicator');
                    },
                    function (Builder $query) {
                        $query->addSelect(new Alias(new Value('total'), 'indicator'));
                    }
                ),
            'indicator'
        );
    }
}
