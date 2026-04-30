<?php

declare(strict_types=1);

namespace App\Reports\Queries\CommunityActivity;

use App\Enums\CommunityActivity\Campaign;
use App\Models\CommunityActivity;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;

/**
 * Total activități de tip Activitate fizică și nutriție.
 */
class CA07 extends ReportQuery
{
    public static function query(): Builder
    {
        return CommunityActivity::query()
            ->whereCampaign(Campaign::ACTIVITY);
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
