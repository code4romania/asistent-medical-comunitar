<?php

declare(strict_types=1);

namespace App\Reports\Queries\CasesHealth;

use Illuminate\Database\Eloquent\Builder;

/**
 * Total management de caz închise pentru Adicții / dependențe.
 */
class CH47 extends CasesHealthQuery
{
    public static function query(): Builder
    {
        return parent::query()
            ->whereSecondaryVulnerability('VSG_AD');
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
