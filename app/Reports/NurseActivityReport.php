<?php

declare(strict_types=1);

namespace App\Reports;

use App\Enums\Report\Type;
use App\Models\Beneficiary;
use Illuminate\Contracts\Database\Query\Expression;
use Illuminate\Database\Eloquent\Builder;
use Tpetry\QueryExpressions\Operator\Comparison\Between;
use Tpetry\QueryExpressions\Operator\Comparison\Equal;
use Tpetry\QueryExpressions\Operator\Comparison\GreaterThanOrEqual;
use Tpetry\QueryExpressions\Value\Value;

class NurseActivityReport extends ReportFactory
{
    protected Type $type = Type::NURSE_ACTIVITY;

    protected function queryBeneficiaries(array $values, array $segments): array
    {
        $columns = collect($segments)
            ->map(fn (array|string $segment) => static::countFilter($segment))
            ->all();

        return $this->runQueryFor(
            Beneficiary::class,
            fn (Builder $query) => $query->select($columns)
                ->addSelect('status')
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
                ->whereIn('status', $values)
                ->groupBy('status')
        );
    }

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
}
