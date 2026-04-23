<?php

declare(strict_types=1);

namespace App\Reports\Queries\CasesHealth;

use Illuminate\Database\Eloquent\Builder;

class CH01 extends CasesHealthQuery
{
    /**
     * Total management de caz create (nou inițiate).
     */
    public static function query(): Builder
    {
        return parent::query();
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
