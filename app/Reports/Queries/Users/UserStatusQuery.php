<?php

declare(strict_types=1);

namespace App\Reports\Queries\Users;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;

abstract class UserStatusQuery extends UsersQuery
{
    public static function query(): Builder
    {
        return User::query()
            ->onlyNurses()
            ->whereHasActivity(fn (Builder $query) => static::latestBeforeRangeTimeline($query, 'activity_log'));
    }

    public static function statusColumn(): string
    {
        return 'activity_log.properties->attributes->status';
    }

    public static function dateColumn(string $type): string
    {
        return 'activity_log.created_at';
    }

    public static function aggregateByColumn(): string
    {
        return 'subject_id';
    }

    public static function includeLatestBeforeRange(): bool
    {
        return true;
    }

    public static function latestBeforeRangeTable(): string
    {
        return 'activity_log';
    }

    public static function latestBeforeRangePartition(): string
    {
        return 'subject_id';
    }

    public static function latestBeforeRangeTimeline(Builder|QueryBuilder $query, string $table): void
    {
        $query
            ->where("{$table}.subject_type", 'user')
            ->where("{$table}.log_name", 'default')
            ->whereJsonContainsKey("{$table}.properties->attributes->status");
    }
}
