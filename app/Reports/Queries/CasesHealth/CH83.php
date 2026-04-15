<?php

declare(strict_types=1);

namespace App\Reports\Queries\CasesHealth;

use App\Models\Intervention;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;

class CH83 extends ReportQuery
{
    /**
     * Total management de caz închise pentru Femeie de vârstă fertilă.
     */
    public static function query(): Builder
    {
        return Intervention::query()
            ->without('appointment', 'interventionable')
            ->whereVulnerability('VGR_10')
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
