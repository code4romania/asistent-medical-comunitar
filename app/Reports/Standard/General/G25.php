<?php

declare(strict_types=1);

namespace App\Reports\Standard\General;

use App\Models\CommunityActivity;
use Illuminate\Database\Eloquent\Builder;

class G25 extends GeneralReport
{
    /**
     * Sum activități comunitare Campanii sănătate and tip=Anunțare pentru screening populațional.
     * TODO: filter by type.
     */
    public function query(): Builder
    {
        return CommunityActivity::query()
            ->onlyCampaigns();
    }
}
