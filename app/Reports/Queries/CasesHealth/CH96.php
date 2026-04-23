<?php

declare(strict_types=1);

namespace App\Reports\Queries\CasesHealth;

use Illuminate\Database\Eloquent\Builder;

class CH96 extends CasesHealthQuery
{
    /**
     * Total management de caz create (nou inițiate) pentru Copil 0-1 ani.
     */
    public static function query(): Builder
    {
        return parent::query()
            ->whereVulnerability('VCV_01');
    }

    public static function dateColumn(string $type): string
    {
        return 'interventions.created_at';
    }

    public static function includeLatestBeforeRange(): bool
    {
        return false;
    }
}
