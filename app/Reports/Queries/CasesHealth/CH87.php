<?php

declare(strict_types=1);

namespace App\Reports\Queries\CasesHealth;

use Illuminate\Database\Eloquent\Builder;

/**
 * Total management de caz închise pentru Femeie însărcinată care nu este în evidența medicului de familie.
 */
class CH87 extends CasesHealthQuery
{
    public static function query(): Builder
    {
        return parent::query()
            ->whereVulnerability('VGR_05');
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
