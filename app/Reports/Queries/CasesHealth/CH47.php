<?php

declare(strict_types=1);

namespace App\Reports\Queries\CasesHealth;

use Illuminate\Database\Eloquent\Builder;

class CH47 extends CasesHealthQuery
{
    /**
     * Total management de caz închise pentru Adicții / dependențe.
     */
    public static function query(): Builder
    {
        return parent::query()
            ->whereVulnerability('VSG_AD');
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
