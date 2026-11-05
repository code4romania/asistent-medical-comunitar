<?php

declare(strict_types=1);

namespace App\Reports\Queries\Users;

use App\Enums\Employer\Funding;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

/**
 * Total utilizatori angajați pe post cu finanțare din proiect cu fonduri în perioada de referință.
 */
class U08 extends UsersQuery
{
    public static function query(): Builder
    {
        return User::query()
            ->onlyNurses()
            ->leftJoin('profile_employers', 'profile_employers.user_id', 'users.id')
            ->where('funding', Funding::PROJECT);
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
}
