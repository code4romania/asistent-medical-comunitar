<?php

declare(strict_types=1);

namespace App\Reports\Queries\Interventions;

use App\Enums\Intervention\CaseInitiator;
use App\Models\Intervention;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;

class I03 extends ReportQuery
{
    /**
     * Total intervenții de tip Management de caz active deschise la inițiativa proprie.
     */
    public static function query(): Builder
    {
        return Intervention::query()
            ->without('appointment', 'interventionable')
            ->whereInitiatedBy(CaseInitiator::NURSE)
            ->onlyCases();
    }

    public static function dateColumn(string $type): string
    {
        return match ($type) {
            'start' => 'created_at',
            'end' => 'closed_at',
        };
    }

    public static function aggregateByColumn(): string
    {
        return 'interventions.id';
    }

    public static function includeLatestBeforeRange(): bool
    {
        return false;
    }

    public static function endDateNullable(): bool
    {
        return true;
    }
}
