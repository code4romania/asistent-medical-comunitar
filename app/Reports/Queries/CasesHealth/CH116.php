<?php

declare(strict_types=1);

namespace App\Reports\Queries\CasesHealth;

use Illuminate\Database\Eloquent\Builder;

class CH116 extends CasesHealthQuery
{
    /**
     * Total management de caz închise pentru Copil în plasament sau asistență maternală în condiții de risc.
     */
    public static function query(): Builder
    {
        return parent::query()
            ->whereVulnerability('VFC_05');
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
