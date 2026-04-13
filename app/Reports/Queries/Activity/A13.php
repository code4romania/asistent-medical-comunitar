<?php

declare(strict_types=1);

namespace App\Reports\Queries\Activity;

use App\Models\Appointment;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;

class A13 extends ReportQuery
{
    /**
     * Total programări în perioada de referință.
     */
    public static function query(): Builder
    {
        return Appointment::query();
    }

    public static function dateColumn(string $type): string
    {
        return 'date';
    }

    public static function includeLatestBeforeRange(): bool
    {
        return false;
    }

    public static function selectColumns(): array
    {
        return [
            'id',
            'date',
            'beneficiary_id',
        ];
    }
}
