<?php

declare(strict_types=1);

namespace App\Reports\Queries\CasesHealth;

use Illuminate\Database\Eloquent\Builder;

class CH65 extends CasesHealthQuery
{
    /**
     * Total management de caz închise pentru Alt tip de afecțiune.
     */
    public static function query(): Builder
    {
        return parent::query()
            ->whereVulnerability('VSG_ALT');
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
