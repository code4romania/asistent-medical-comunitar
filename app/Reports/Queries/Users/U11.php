<?php

declare(strict_types=1);

namespace App\Reports\Queries\Users;

use App\Models\Vacation;
use Illuminate\Database\Eloquent\Builder;

/**
 * Total zile de concediu medical înregistrate în perioada de referință.
 */
class U11 extends VacationsQuery
{
    public static function query(): Builder
    {
        return Vacation::query()
            ->whereMedical();
    }
}
