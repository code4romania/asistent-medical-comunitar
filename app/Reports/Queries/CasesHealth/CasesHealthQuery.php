<?php

declare(strict_types=1);

namespace App\Reports\Queries\CasesHealth;

use App\Reports\Queries\InterventionReportQuery;
use Illuminate\Database\Eloquent\Builder;

abstract class CasesHealthQuery extends InterventionReportQuery
{
    public static function query(): Builder
    {
        return parent::query()
            ->onlyCases();
    }

    public static function selectColumns(): array
    {
        return [
            'interventions.id',
            'interventions.created_at',
        ];
    }
}
