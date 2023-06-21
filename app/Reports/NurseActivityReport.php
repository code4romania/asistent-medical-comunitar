<?php

declare(strict_types=1);

namespace App\Reports;

use App\Enums\Report\Type;
use App\Models\Beneficiary;
use Illuminate\Contracts\Database\Query\Expression;
use Illuminate\Database\Eloquent\Builder;
use Tpetry\QueryExpressions\Language\Alias;
use Tpetry\QueryExpressions\Operator\Comparison\Between;
use Tpetry\QueryExpressions\Operator\Comparison\Equal;
use Tpetry\QueryExpressions\Operator\Comparison\GreaterThanOrEqual;
use Tpetry\QueryExpressions\Value\Value;

class NurseActivityReport extends ReportFactory
{
    protected Type $type = Type::NURSE_ACTIVITY;

    protected function segmentByAge(string $value): Expression
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

    protected function segmentByGender(string $value): Expression
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
}
