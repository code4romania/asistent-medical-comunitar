<?php

declare(strict_types=1);

namespace App\Reports\Queries\Interventions;

use Illuminate\Database\Eloquent\Builder;

/**
 * Total servicii realizate pentru vulnerabilități legate de Medic de familie.
 */
class I17 extends InterventionsQuery
{
    public static function query(): Builder
    {
        return parent::query()
            ->leftJoin('interventionable_individual_services', 'interventions.interventionable_id', '=', 'interventionable_individual_services.id')
            ->whereVulnerabilityCategory('MF')
            ->onlyRealized();
    }
}
