<?php

declare(strict_types=1);

namespace App\Reports\Queries\Activity;

use App\Enums\Intervention\Status;
use App\Models\Intervention\InterventionableIndividualService;
use Illuminate\Database\Eloquent\Builder;

/**
 * Total servicii realizate în afara programului de lucru (în perioada de referință).
 */
class A12 extends ActivityInterventionQuery
{
    public static function query(): Builder
    {
        return parent::query()
            ->leftJoin('interventionable_individual_services', 'interventions.interventionable_id', '=', 'interventionable_individual_services.id')
            ->whereHasMorph('interventionable', InterventionableIndividualService::class, function (Builder $query): void {
                $query
                    ->where('status', Status::REALIZED)
                    ->where('outside_working_hours', true);
            });
    }
}
