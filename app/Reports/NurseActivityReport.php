<?php

declare(strict_types=1);

namespace App\Reports;

use App\Enums\Report\Type;
use App\Models\Beneficiary;
use Illuminate\Database\Eloquent\Builder;

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
                ->whereIn('status', $values)
                ->groupBy('status')
        );
    }
}
