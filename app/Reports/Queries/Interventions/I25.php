<?php

declare(strict_types=1);

namespace App\Reports\Queries\Interventions;

use App\Reports\Queries\InterventionReportQuery;
use Illuminate\Database\Eloquent\Builder;

/**
 * Total servicii realizate pentru vulnerabilități legate de Statut de gravidă.
 */
class I25 extends InterventionReportQuery
{
    public static function query(): Builder
    {
        return parent::query()
            ->leftJoin('interventionable_individual_services', 'interventions.interventionable_id', '=', 'interventionable_individual_services.id')
            ->whereVulnerabilityCategory('PREG')
            ->onlyRealized();
    }
}
