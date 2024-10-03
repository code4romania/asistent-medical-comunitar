<?php

declare(strict_types=1);

namespace App\Reports\Queries\General;

use App\Models\CommunityActivity;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;

class G25 extends ReportQuery
{
    /**
     * Sum activități comunitare Campanii sănătate and tip=Anunțare pentru screening populațional.
     * TODO: filter by type.
     */
    public static function query(): Builder
    {
        return CommunityActivity::query()
            ->onlyCampaigns();
    }
}
