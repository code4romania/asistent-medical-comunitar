<?php

declare(strict_types=1);

namespace App\Reports\Queries\CasesHealth;

use App\Models\Report;
use Illuminate\Database\Eloquent\Builder;

/**
 * Total management de caz active pentru Diabet zaharat.
 */
class CH26 extends CasesHealthQuery
{
    public static function query(): Builder
    {
        return parent::query()
            ->whereSecondaryVulnerability('VSG_DZ');
    }

    public static function where(Builder $query, Report $report): Builder
    {
        return $query->where('interventions.created_at', '<=', $report->datetime_until);
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
