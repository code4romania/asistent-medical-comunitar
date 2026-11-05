<?php

declare(strict_types=1);

namespace App\Reports\Queries\Users;

use Illuminate\Database\Eloquent\Builder;

abstract class VacationsQuery extends UsersQuery
{
    public static function dateColumn(string $type): string
    {
        return match ($type) {
            'start' => 'end_date',
            'end' => 'start_date',
        };
    }

    public static function selectColumns(): array
    {
        return [
            'vacations.id',
        ];
    }

    public static function tapQuery(Builder $query): Builder
    {
        return $query
            ->leftJoin('users', 'users.id', 'vacations.user_id')
            ->addSelect('vacations.user_id');
    }

    public static function segmentColumns(): array
    {
        return [
            'nurse_id' => 'vacations.user_id',
            'county_id' => 'users.activity_county_id',
        ];
    }
}
