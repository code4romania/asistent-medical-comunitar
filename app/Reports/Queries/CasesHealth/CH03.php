<?php

declare(strict_types=1);

namespace App\Reports\Queries\CasesHealth;

/**
 * Total management de caz închise.
 */
class CH03 extends CasesHealthQuery
{
    public static function dateColumn(string $type): string
    {
        return 'closed_at';
    }

    public static function includeLatestBeforeRange(): bool
    {
        return false;
    }
}
