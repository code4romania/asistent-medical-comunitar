<?php

declare(strict_types=1);

namespace App\Reports\Queries\Activity;

use App\Enums\AggregateFunction;
use App\Models\Appointment;
use Illuminate\Database\Eloquent\Builder;
use Tpetry\QueryExpressions\Language\Alias;

/**
 * Număr mediu de servicii per programare în perioada de referință.
 */
class A14 extends ActivityQuery
{
    public static function query(): Builder
    {
        return Appointment::query()
            ->leftJoin('beneficiaries', 'beneficiaries.id', '=', 'appointments.beneficiary_id')
            ->leftJoin('users', 'users.id', '=', 'appointments.nurse_id')
            ->fromSub(
                Appointment::query()
                    ->withCount('interventions'),
                'appointments'
            );
    }

    public static function tapQuery(Builder $query): Builder
    {
        return $query->addSelect([
            'appointments.nurse_id',
            new Alias('users.activity_county_id', 'county_id'),
            'appointments.interventions_count',
        ]);
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
