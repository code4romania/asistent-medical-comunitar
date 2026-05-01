<?php

declare(strict_types=1);

namespace App\Reports\Queries\CommunityActivity;

use App\Enums\AggregateFunction;
use App\Enums\CommunityActivity\Campaign;
use Illuminate\Database\Eloquent\Builder;

/**
 * Total beneficiari de etnie romă deserviți prin activități de tip Triaj epidemiologic.
 */
class CA18 extends CommunityActivityQuery
{
    public static function query(): Builder
    {
        return parent::query()
            ->whereCampaign(Campaign::EPIDEM_TRIAGE);
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
