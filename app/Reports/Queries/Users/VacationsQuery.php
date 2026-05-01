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
            'vacations.created_at',
        ];
    }

    public static function tapQuery(Builder $query): Builder
    {
        return $query
            ->addSelect('vacations.nurse_id');
    }
}
