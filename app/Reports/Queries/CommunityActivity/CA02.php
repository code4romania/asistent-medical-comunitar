<?php

declare(strict_types=1);

namespace App\Reports\Queries\CommunityActivity;

use App\Enums\AggregateFunction;
use App\Enums\CommunityActivity\Campaign;
use Illuminate\Database\Eloquent\Builder;

/**
 * Total beneficiari deserviți prin activități de tip Campanie națională.
 */
class CA02 extends CommunityActivityQuery
{
    public static function query(): Builder
    {
        return parent::query()
            ->whereCampaign(Campaign::NATIONAL);
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
