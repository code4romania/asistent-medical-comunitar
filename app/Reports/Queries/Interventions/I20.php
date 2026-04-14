<?php

declare(strict_types=1);

namespace App\Reports\Queries\Interventions;

use App\Models\Intervention;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;

class I20 extends ReportQuery
{
    /**
     * Total servicii realizate pentru vulnerabilități legate de Nevoi de sănătate.
     */
    public static function query(): Builder
    {
        return Intervention::query()
            ->without('appointment', 'interventionable')
            ->leftJoin('interventionable_individual_services', 'interventions.interventionable_id', '=', 'interventionable_individual_services.id')
            ->whereVulnerabilityCategory('NS')
            ->onlyRealized();
    }

    public static function dateColumn(string $type): string
    {
        return 'interventionable_individual_services.date';
    }

    public static function aggregateByColumn(): string
    {
        return 'interventions.id';
    }

    public static function includeLatestBeforeRange(): bool
    {
        return false;
    }
}
