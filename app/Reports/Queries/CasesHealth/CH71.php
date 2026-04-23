<?php

declare(strict_types=1);

namespace App\Reports\Queries\CasesHealth;

use Illuminate\Database\Eloquent\Builder;

class CH71 extends CasesHealthQuery
{
    /**
     * Total management de caz închise pentru Mamă (sau lăuză) minoră.
     */
    public static function query(): Builder
    {
        return parent::query()
            ->whereVulnerability(['VGR_02', 'VGR_03']);
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
