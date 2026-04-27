<?php

declare(strict_types=1);

namespace App\Reports\Queries\Users;

use App\Models\Vacation;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;

class U15 extends ReportQuery
{
    /**
     * Total zile libere pentru donare de sânge înregistrate în perioada de referință.
     */
    public static function query(): Builder
    {
        return Vacation::query()
            ->whereBloodDonation();
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
