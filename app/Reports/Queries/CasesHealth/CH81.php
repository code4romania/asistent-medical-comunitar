<?php

declare(strict_types=1);

namespace App\Reports\Queries\CasesHealth;

use Illuminate\Database\Eloquent\Builder;

class CH81 extends CasesHealthQuery
{
    /**
     * Total management de caz create (nou inițiate) pentru Femeie post-avort.
     */
    public static function query(): Builder
    {
        return parent::query()
            ->whereVulnerability('VGR_09');
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
