<?php

declare(strict_types=1);

namespace App\Reports\Queries\Users;

use App\Enums\Employer\Funding;
use App\Models\User;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;

/**
 * Total utilizatori angajați din buget local.
 */
class U07 extends ReportQuery
{
    public static function query(): Builder
    {
        return User::query()
            ->onlyNurses()
            ->leftJoin('profile_employers', 'profile_employers.user_id', 'users.id')
            ->where('funding', Funding::LOCAL);
    }

    public static function aggregateByColumn(): string
    {
        return 'users.id';
    }

    public static function dateColumn(string $type): string
    {
        return match ($type) {
            'start' => 'end_date',
            'end' => 'start_date',
        };
    }

    public static function startDateNullable(): bool
    {
        return true;
    }

    public static function includeLatestBeforeRange(): bool
    {
        return false;
    }
}
