<?php

declare(strict_types=1);

namespace App\Reports\Queries\CasesHealth;

use Illuminate\Database\Eloquent\Builder;

/**
 * Total management de caz închise pentru Afecțiuni oncologice.
 */
class CH51 extends CasesHealthQuery
{
    public static function query(): Builder
    {
        return parent::query()
            ->whereSecondaryVulnerability('VSG_ONC');
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
