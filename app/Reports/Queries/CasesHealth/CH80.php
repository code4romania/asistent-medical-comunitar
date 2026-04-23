<?php

declare(strict_types=1);

namespace App\Reports\Queries\CasesHealth;

use Illuminate\Database\Eloquent\Builder;

class CH80 extends CasesHealthQuery
{
    /**
     * Total management de caz închise pentru Femeie post-avort.
     */
    public static function query(): Builder
    {
        return parent::query()
            ->whereVulnerability('VGR_09');
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
