<?php

declare(strict_types=1);

namespace App\Reports\Queries\CommunityActivity;

use App\Enums\CommunityActivity\Campaign;
use Illuminate\Database\Eloquent\Builder;

/**
 * Total activități de tip Intervenție scurtă în comunitățile vulnerabile.
 */
class CA10 extends CommunityActivityQuery
{
    public static function query(): Builder
    {
        return parent::query()
            ->whereCampaign(Campaign::INTERVENTION);
    }
}
