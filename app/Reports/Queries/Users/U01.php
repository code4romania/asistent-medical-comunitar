<?php

declare(strict_types=1);

namespace App\Reports\Queries\Users;

use App\Models\User;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;

class U01 extends ReportQuery
{
    /**
     * Total utilizatori existenți în platformă în perioada de referință.
     */
    public static function query(): Builder
    {
        return User::query()
            ->onlyNurses();
    }
}
