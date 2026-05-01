<?php

declare(strict_types=1);

namespace App\Reports\Queries\CommunityActivity;

use App\Enums\AggregateFunction;
use App\Enums\CommunityActivity\Campaign;
use Illuminate\Database\Eloquent\Builder;

/**
 * Total beneficiari deserviți prin activități de tip Intervenție scurtă în comunitățile vulnerabile.
 */
class CA11 extends CommunityActivityQuery
{
    public static function query(): Builder
    {
        return parent::query()
            ->whereCampaign(Campaign::INTERVENTION);
    }

    public static function aggregateFunction(): AggregateFunction
    {
        return AggregateFunction::SUM;
    }

    public static function aggregateByColumn(): string
    {
        return 'participants';
    }
}
