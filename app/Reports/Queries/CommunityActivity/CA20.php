<?php

declare(strict_types=1);

namespace App\Reports\Queries\CommunityActivity;

use App\Enums\CommunityActivity\Administrative;
use App\Models\CommunityActivity;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;

class CA20 extends ReportQuery
{
    /**
     * Total activități de tip Ședință.
     */
    public static function query(): Builder
    {
        return CommunityActivity::query()
            ->whereAdministrativeActivity(Administrative::MEETING);
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
