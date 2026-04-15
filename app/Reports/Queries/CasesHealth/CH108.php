<?php

declare(strict_types=1);

namespace App\Reports\Queries\CasesHealth;

use App\Models\Intervention;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;

class CH108 extends ReportQuery
{
    /**
     * Total management de caz create (nou inițiate) pentru Copil care nu este în conformitate cu standardele de dezvoltare.
     */
    public static function query(): Builder
    {
        return Intervention::query()
            ->without('appointment', 'interventionable')
            ->whereVulnerability('VSC_06')
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
