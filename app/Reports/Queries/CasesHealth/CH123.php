<?php

declare(strict_types=1);

namespace App\Reports\Queries\CasesHealth;

use Illuminate\Database\Eloquent\Builder;

/**
 * Total management de caz închise pentru Vârstnic care locuiește singur.
 */
class CH123 extends CasesHealthQuery
{
    public static function query(): Builder
    {
        return parent::query()
            ->whereVulnerability('VFA_02');
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
