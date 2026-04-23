<?php

declare(strict_types=1);

namespace App\Reports\Queries\CasesHealth;

use App\Models\Intervention;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;

abstract class CasesHealthQuery extends ReportQuery
{
    public static function query(): Builder
    {
        return Intervention::query()
            ->withoutEagerLoads()
            ->onlyCases()
            ->leftJoin('beneficiaries', 'beneficiaries.id', 'interventions.beneficiary_id');
    }

    public static function selectColumns(): array
    {
        return [
            'interventions.id',
            'interventions.created_at',
        ];
    }

    public static function aggregateByColumn(): string
    {
        return 'interventions.id';
    }
}
