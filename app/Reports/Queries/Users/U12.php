<?php

declare(strict_types=1);

namespace App\Reports\Queries\Users;

use App\Models\Vacation;
use Illuminate\Database\Eloquent\Builder;

/**
 * Total zile de concediu pentru creșterea copilului înregistrate în perioada de referință.
 */
class U12 extends VacationsQuery
{
    public static function query(): Builder
    {
        return Vacation::query()
            ->whereChild();
    }
}
