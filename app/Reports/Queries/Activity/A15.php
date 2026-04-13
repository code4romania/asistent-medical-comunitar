<?php

declare(strict_types=1);

namespace App\Reports\Queries\Activity;

use App\Models\CommunityActivity;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;

class A15 extends ReportQuery
{
    /**
     * Total activități comunitare realizate în perioada de referință.
     */
    public static function query(): Builder
    {
        return CommunityActivity::query();
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
