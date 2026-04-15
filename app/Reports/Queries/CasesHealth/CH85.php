<?php

declare(strict_types=1);

namespace App\Reports\Queries\CasesHealth;

use App\Models\Intervention;
use App\Models\Report;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;

class CH85 extends ReportQuery
{
    /**
     * Total management de caz active pentru Femeie însărcinată care nu este în evidența medicului de familie.
     */
    public static function query(): Builder
    {
        return Intervention::query()
            ->without('appointment', 'interventionable')
            ->whereVulnerability('VGR_05')
            ->onlyCases();
    }

    public static function where(Builder $query, Report $report): Builder
    {
        return $query->whereDate('created_at', '<=', $report->date_until);
    }

    public static function dateColumn(string $type): string
    {
        return 'closed_at';
    }

    public static function includeLatestBeforeRange(): bool
    {
        return false;
    }

    public static function startDateNullable(): bool
    {
        return true;
    }

    public static function endDateNullable(): bool
    {
        return true;
    }
}
