<?php

declare(strict_types=1);

namespace App\Reports\Queries\CommunityActivity;

use App\Enums\CommunityActivity\Campaign;
use App\Models\CommunityActivity;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;

class CA01 extends ReportQuery
{
    /**
     * Total activități de tip Campanie națională.
     */
    public static function query(): Builder
    {
        return CommunityActivity::query()
            ->whereCampaign(Campaign::NATIONAL);
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
