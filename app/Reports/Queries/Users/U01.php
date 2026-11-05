<?php

declare(strict_types=1);

namespace App\Reports\Queries\Users;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

/**
 * Total utilizatori existenți în platformă în perioada de referință.
 */
class U01 extends UsersQuery
{
    public static function query(): Builder
    {
        return User::query()
            ->onlyNurses();
    }

    public static function dateColumn(string $type): string
    {
        return 'created_at';
    }

    public static function omitStartDate(): bool
    {
        return true;
    }
}
