<?php

declare(strict_types=1);

namespace App\Reports\Queries\Activity;

use Illuminate\Database\Eloquent\Builder;

/**
 * Total servicii realizate în perioada de referință.
 */
class A09 extends ActivityInterventionQuery
{
    public static function query(): Builder
    {
        return parent::query()
            ->leftJoin('interventionable_individual_services', 'interventions.interventionable_id', '=', 'interventionable_individual_services.id')
            ->onlyRealized();
    }
}
