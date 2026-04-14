<?php

declare(strict_types=1);

namespace App\Reports\Queries\CommunityActivity;

use App\Enums\AggregateFunction;
use App\Enums\CommunityActivity\Campaign;
use App\Models\CommunityActivity;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;

class CA09 extends ReportQuery
{
    /**
     * Total beneficiari de etnie romă deserviți prin activități de tip Activitate fizică și nutriție.
     */
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

    public static function aggregateFunction(): AggregateFunction
    {
        return AggregateFunction::SUM;
    }

    public static function aggregateByColumn(): string
    {
        return 'roma_participants';
    }
}
