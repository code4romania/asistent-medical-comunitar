<?php

declare(strict_types=1);

namespace App\Reports\Queries\CasesHealth;

use App\Models\Intervention;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;

class CH69 extends ReportQuery
{
    /**
     * Total management de caz create (nou inițiate) pentru Minoră gravidă.
     */
    public static function query(): Builder
    {
        return Intervention::query()
            ->without('appointment', 'interventionable')
            ->whereVulnerability('VGR_01')
            ->onlyCases();
    }

    public static function dateColumn(string $type): string
    {
        return 'created_at';
    }

    public static function includeLatestBeforeRange(): bool
    {
        return false;
    }
}
