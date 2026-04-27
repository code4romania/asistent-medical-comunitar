<?php

declare(strict_types=1);

namespace App\Reports\Queries\Users;

use App\Models\User;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;

class U10 extends ReportQuery
{
    /**
     * Total utilizatori cu acrod de parteneriat între angajator și medicul de familie în perioada de referință.
     */
    public static function query(): Builder
    {
        return User::query()
            ->onlyNurses()
            ->leftJoin('profile_employers', 'profile_employers.user_id', 'users.id')
            ->where('has_gp_agreement', true);
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
