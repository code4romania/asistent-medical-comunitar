<?php

declare(strict_types=1);

namespace App\Reports\Queries\Users;

use App\Models\Vacation;
use Illuminate\Database\Eloquent\Builder;

/**
 * Total zile de concediu de odihnă înregistrate în perioada de referință.
 */
class U10 extends VacationsQuery
{
    public static function query(): Builder
    {
        return Vacation::query()
            ->whereRest();
    }
}
