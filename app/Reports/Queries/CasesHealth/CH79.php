<?php

declare(strict_types=1);

namespace App\Reports\Queries\CasesHealth;

use App\Models\Report;
use Illuminate\Database\Eloquent\Builder;

class CH79 extends CasesHealthQuery
{
    /**
     * Total management de caz active pentru Femeie post-avort.
     */
    public static function query(): Builder
    {
        return parent::query()
            ->whereVulnerability('VGR_09');
    }

    public static function where(Builder $query, Report $report): Builder
    {
        return $query->whereDate('interventions.created_at', '<=', $report->date_until);
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
