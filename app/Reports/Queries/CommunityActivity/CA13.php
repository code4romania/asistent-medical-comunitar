<?php

declare(strict_types=1);

namespace App\Reports\Queries\CommunityActivity;

use App\Enums\CommunityActivity\Campaign;
use Illuminate\Database\Eloquent\Builder;

/**
 * Total activități de tip Anunțare pentru screening populațional.
 */
class CA13 extends CommunityActivityQuery
{
    public static function query(): Builder
    {
        return parent::query()
            ->whereCampaign(Campaign::SCREENING);
    }
}
