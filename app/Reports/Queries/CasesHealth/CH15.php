<?php

declare(strict_types=1);

namespace App\Reports\Queries\CasesHealth;

use Illuminate\Database\Eloquent\Builder;

/**
 * Total management de caz create (nou inițiate) pentru Hepatite cronice virale.
 */
class CH15 extends CasesHealthQuery
{
    public static function query(): Builder
    {
        return parent::query()
            ->whereSecondaryVulnerability('VSG_HEP');
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
