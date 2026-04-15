<?php

declare(strict_types=1);

namespace App\Reports\Queries\CasesHealth;

use App\Models\Intervention;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;

class CH44 extends ReportQuery
{
    /**
     * Total management de caz închise pentru Demență.
     */
    public static function query(): Builder
    {
        return Intervention::query()
            ->without('appointment', 'interventionable')
            ->whereVulnerability('VSG_DEM')
            ->onlyCases();
    }

    public static function dateColumn(string $type): string
    {
        return 'closed_at';
    }

    public static function includeLatestBeforeRange(): bool
    {
        return false;
    }
}
