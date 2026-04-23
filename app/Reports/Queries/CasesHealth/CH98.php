<?php

declare(strict_types=1);

namespace App\Reports\Queries\CasesHealth;

use Illuminate\Database\Eloquent\Builder;

class CH98 extends CasesHealthQuery
{
    /**
     * Total management de caz închise pentru Copil cu greutate scăzută la naștere.
     */
    public static function query(): Builder
    {
        return parent::query()
            ->whereVulnerability('VSC_02');
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
