<?php

declare(strict_types=1);

namespace App\Reports\Queries\Users;

use App\Models\User;
use Illuminate\Contracts\Database\Query\Expression;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Tpetry\QueryExpressions\Language\Alias;

abstract class UserStatusQuery extends UsersQuery
{
    public static function query(): Builder
    {
        return User::query()
            ->fromSub(
                User::query()
                    ->fromSub(
                        User::query()
                            ->onlyNurses()
                            ->select([
                                'users.id',
                                'activity_log.created_at',
                                'activity_county_id',
                                'county_id',
                                new Alias('properties->attributes->status', 'status'),
                                static::rankedPartition(),
                            ])
                            ->whereHasActivity(function (Builder $query) {
                                $query
                                    ->where('log_name', 'default')
                                    ->whereJsonContainsKey('properties->attributes->status');
                            }),
                        'ranked'
                    ),
                'users'
            );
    }

    public static function dateColumn(string $type): string
    {
        return 'created_at';
    }

    public static function includeLatestBeforeRange(): bool
    {
        return true;
    }

    public static function rankedLatestBeforeRange(): bool
    {
        return true;
    }

    public static function rankedPartition(): Expression
    {
        return DB::raw('ROW_NUMBER() OVER (PARTITION BY users.id ORDER BY activity_log.created_at DESC) as rn');
    }

    public static function selectColumns(): array
    {
        return [
            'id',
            'activity_county_id',
            new Alias('activity_county_id', 'county_id'),
        ];
    }
}
