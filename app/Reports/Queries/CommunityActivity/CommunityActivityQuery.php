<?php

declare(strict_types=1);

namespace App\Reports\Queries\CommunityActivity;

use App\Models\CommunityActivity;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;
use Tpetry\QueryExpressions\Language\Alias;

/**
 * Total activități de tip Campanie națională.
 */
abstract class CommunityActivityQuery extends ReportQuery
{
    public static function query(): Builder
    {
        return CommunityActivity::query()
            ->leftJoin('users', 'community_activities.nurse_id', '=', 'users.id');
    }

    public static function selectColumns(): array
    {
        return [
            'community_activities.id',
            new Alias('users.activity_county_id', 'county_id'),
        ];
    }

    public static function aggregateByColumn(): string
    {
        return 'community_activities.id';
    }

    public static function dateColumn(string $type): string
    {
        return 'community_activities.date';
    }

    public static function includeLatestBeforeRange(): bool
    {
        return false;
    }

    public static function tapQuery(Builder $query): Builder
    {
        return $query
            ->addSelect('users.id as nurse_id');
    }
}
