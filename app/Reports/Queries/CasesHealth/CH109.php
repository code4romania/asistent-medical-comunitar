<?php

declare(strict_types=1);

namespace App\Reports\Queries\CasesHealth;

use Illuminate\Database\Eloquent\Builder;

/**
 * Total management de caz create (nou inițiate) pentru Copil abandonat.
 */
class CH109 extends CasesHealthQuery
{
    public static function query(): Builder
    {
        return parent::query()
            ->whereVulnerability('VFC_07');
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
