<?php

declare(strict_types=1);

namespace App\Reports\Queries\Activity;

use App\Enums\AggregateFunction;
use App\Models\Appointment;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;

class A14 extends ReportQuery
{
    /**
     * Număr mediu de servicii per programare în perioada de referință.
     */
    public static function query(): Builder
    {
        return Appointment::query()
            ->fromSub(
                Appointment::query()
                    ->withCount('interventions'),
                'appointments'
            );
    }

    public static function dateColumn(string $type): string
    {
        return 'date';
    }

    public static function includeLatestBeforeRange(): bool
    {
        return false;
    }

    public static function aggregateFunction(): AggregateFunction
    {
        return AggregateFunction::AVG;
    }

    public static function aggregateByColumn(): string
    {
        return 'interventions_count';
    }
}
