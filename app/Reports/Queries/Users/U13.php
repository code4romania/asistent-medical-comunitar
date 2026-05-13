<?php

declare(strict_types=1);

namespace App\Reports\Queries\Users;

use App\Models\Vacation;
use Illuminate\Database\Eloquent\Builder;

/**
 * Total zile libere speciale (deces, căsătorie, naștere) înregistrate în perioada de referință.
 */
class U13 extends VacationsQuery
{
    public static function query(): Builder
    {
        return Vacation::query()
            ->whereSpecial();
    }
}
