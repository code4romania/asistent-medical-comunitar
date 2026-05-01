<?php

declare(strict_types=1);

namespace App\Reports\Queries\Activity;

use App\Models\Appointment;
use Illuminate\Database\Eloquent\Builder;

/**
 * Total programări în perioada de referință.
 */
class A13 extends ActivityQuery
{
    public static function query(): Builder
    {
        return Appointment::query();
    }

    public static function tapQuery(Builder $query): Builder
    {
        return $query->addSelect([
            'appointments.nurse_id',
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
}
