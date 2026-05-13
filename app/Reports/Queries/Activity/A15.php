<?php

declare(strict_types=1);

namespace App\Reports\Queries\Activity;

use App\Models\CommunityActivity;
use Illuminate\Database\Eloquent\Builder;
use Tpetry\QueryExpressions\Language\Alias;

/**
 * Total activități comunitare realizate în perioada de referință.
 */
class A15 extends ActivityQuery
{
    public static function query(): Builder
    {
        return CommunityActivity::query()
            ->leftJoin('users', 'users.id', '=', 'community_activities.nurse_id');
    }

    public static function tapQuery(Builder $query): Builder
    {
        return $query->addSelect([
            'community_activities.nurse_id',
            new Alias('users.activity_county_id', 'county_id'),
        ]);
    }

    public static function dateColumn(string $type): string
    {
        return 'date';
    }

    public static function aggregateByColumn(): string
    {
        return 'community_activities.id';
    }

    public static function includeLatestBeforeRange(): bool
    {
        return false;
    }
}
