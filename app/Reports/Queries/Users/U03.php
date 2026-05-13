<?php

declare(strict_types=1);

namespace App\Reports\Queries\Users;

use App\Enums\User\Status;
use Illuminate\Database\Eloquent\Builder;

/**
 * Total utilizatori cu status Inctiv în perioada de referință.
 */
class U03 extends UserStatusQuery
{
    public static function query(): Builder
    {
        return parent::query()
            ->where('status', Status::INACTIVE);
    }
}
