<?php

declare(strict_types=1);

namespace App\Reports\Queries\CommunityActivity;

use App\Enums\AggregateFunction;
use App\Enums\CommunityActivity\Campaign;
use Illuminate\Database\Eloquent\Builder;

/**
 * Total beneficiari deserviți prin activități de tip Activitate fizică și nutriție.
 */
class CA08 extends CommunityActivityQuery
{
    public static function query(): Builder
    {
        return parent::query()
            ->whereCampaign(Campaign::ACTIVITY);
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
