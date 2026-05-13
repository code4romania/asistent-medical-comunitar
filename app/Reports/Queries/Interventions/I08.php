<?php

declare(strict_types=1);

namespace App\Reports\Queries\Interventions;

use Illuminate\Database\Eloquent\Builder;

/**
 * Total servicii integrate realizate.
 */
class I08 extends InterventionsQuery
{
    public static function query(): Builder
    {
        return parent::query()
            ->leftJoin('interventionable_individual_services', 'interventions.interventionable_id', '=', 'interventionable_individual_services.id')
            ->where('interventions.integrated', true)
            ->onlyRealized();
    }
}
