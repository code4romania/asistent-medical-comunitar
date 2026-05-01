<?php

declare(strict_types=1);

namespace App\Reports\Queries\Interventions;

use Illuminate\Database\Eloquent\Builder;

/**
 * Total management caz integrate active.
 */
class I07 extends InterventionsQuery
{
    public static function query(): Builder
    {
        return parent::query()
            ->where('interventions.integrated', true)
            ->onlyCases();
    }

    public static function dateColumn(string $type): string
    {
        return match ($type) {
            'start' => 'interventions.created_at',
            'end' => 'interventions.closed_at',
        };
    }

    public static function endDateNullable(): bool
    {
        return true;
    }
}
