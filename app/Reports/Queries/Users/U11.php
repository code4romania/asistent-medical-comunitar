<?php

declare(strict_types=1);

namespace App\Reports\Queries\Users;

use App\Models\Vacation;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;

class U11 extends ReportQuery
{
    /**
     * Total zile de concediu de odihnă înregistrate în perioada de referință.
     */
    public static function query(): Builder
    {
        return Vacation::query()
            ->whereRest();
    }

    public static function dateColumn(string $type): string
    {
        return match ($type) {
            'start' => 'end_date',
            'end' => 'start_date',
        };
    }

    public static function includeLatestBeforeRange(): bool
    {
        return false;
    }
}
