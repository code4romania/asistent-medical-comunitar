<?php

declare(strict_types=1);

namespace App\Reports\Queries\CasesHealth;

use Illuminate\Database\Eloquent\Builder;

class CH53 extends CasesHealthQuery
{
    /**
     * Total management de caz închise pentru Alergii.
     */
    public static function query(): Builder
    {
        return parent::query()
            ->whereVulnerability('VSG_AL');
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
