<?php

declare(strict_types=1);

namespace App\Reports\Queries\Interventions;

use App\Enums\Intervention\CaseInitiator;
use Illuminate\Database\Eloquent\Builder;

/**
 * Total intervenții de tip Management de caz active deschise la inițiativa altei entități.
 */
class I06 extends InterventionsQuery
{
    public static function query(): Builder
    {
        return parent::query()
            ->whereInitiatedBy(CaseInitiator::OTHER)
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
