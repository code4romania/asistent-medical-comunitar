<?php

declare(strict_types=1);

namespace App\Reports\Queries\Interventions;

use Illuminate\Database\Eloquent\Builder;

/**
 * Total servicii realizate pentru vulnerabilități legate de Asigurarea socială de sănătate.
 */
class I16 extends InterventionsQuery
{
    public static function query(): Builder
    {
        return parent::query()
            ->leftJoin('interventionable_individual_services', 'interventions.interventionable_id', '=', 'interventionable_individual_services.id')
            ->whereVulnerabilityCategory('AS')
            ->onlyRealized();
    }
}
