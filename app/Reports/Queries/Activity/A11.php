<?php

declare(strict_types=1);

namespace App\Reports\Queries\Activity;

use App\Enums\Gender;
use App\Enums\Intervention\Status;
use Illuminate\Database\Eloquent\Builder;

/**
 * Total femei cărora li s-au oferit servicii în perioada de referință.
 */
class A11 extends ActivityInterventionQuery
{
    public static function query(): Builder
    {
        return parent::query()
            ->leftJoin('interventionable_individual_services', 'interventions.interventionable_id', '=', 'interventionable_individual_services.id')
            ->where('beneficiaries.gender', '=', Gender::FEMALE)
            ->where('interventionable_individual_services.status', '=', Status::REALIZED)
            ->distinct();
    }

    public static function aggregateByColumn(): string
    {
        return 'beneficiaries.id';
    }
}
