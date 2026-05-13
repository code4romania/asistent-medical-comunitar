<?php

declare(strict_types=1);

namespace App\Reports\Queries\Users;

use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;
use Tpetry\QueryExpressions\Language\Alias;

abstract class UsersQuery extends ReportQuery
{
    public static function dateColumn(string $type): string
    {
        return 'created_at';
    }

    public static function aggregateByColumn(): string
    {
        return 'nurse_id';
    }

    public static function includeLatestBeforeRange(): bool
    {
        return false;
    }

    public static function selectColumns(): array
    {
        return [
            'users.id',
            'activity_county_id',
            new Alias('activity_county_id', 'county_id'),
        ];
    }

    public static function tapQuery(Builder $query): Builder
    {
        return $query
            ->addSelect('users.id as nurse_id');
    }
}
