<?php

declare(strict_types=1);

namespace App\Reports\Queries\CasesHealth;

use Illuminate\Database\Eloquent\Builder;

class CH104 extends CasesHealthQuery
{
    /**
     * Total management de caz închise pentru Copil nevaccinat conform calendarului național.
     */
    public static function query(): Builder
    {
        return parent::query()
            ->whereVulnerability('VSC_01');
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
