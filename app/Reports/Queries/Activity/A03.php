<?php

declare(strict_types=1);

namespace App\Reports\Queries\Activity;

use App\Enums\Beneficiary\Status;
use Illuminate\Database\Eloquent\Builder;

/**
 * Total beneficiari proprii cu status Activ în perioada de referință.
 */
class A03 extends BeneficiaryStatusQuery
{
    public static function query(): Builder
    {
        return parent::query()
            ->where('status', Status::ACTIVE);
    }
}
