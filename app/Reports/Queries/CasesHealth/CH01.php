<?php

declare(strict_types=1);

namespace App\Reports\Queries\CasesHealth;

/**
 * Total management de caz create (nou inițiate).
 */
class CH01 extends CasesHealthQuery
{
    public static function dateColumn(string $type): string
    {
        return 'interventions.created_at';
    }

    public static function includeLatestBeforeRange(): bool
    {
        return false;
    }
}
