<?php

declare(strict_types=1);

namespace App\Reports\Queries\CasesHealth;

use Illuminate\Database\Eloquent\Builder;

class CH125 extends CasesHealthQuery
{
    /**
     * Total management de caz închise pentru Persoană cu dizabilitate (cu sau fără certificat).
     */
    public static function query(): Builder
    {
        return parent::query()
            ->whereVulnerability(['VDH_01', 'VDH_02']);
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
