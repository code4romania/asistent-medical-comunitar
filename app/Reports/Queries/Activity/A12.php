<?php

declare(strict_types=1);

namespace App\Reports\Queries\Activity;

use App\Enums\Intervention\Status;
use App\Models\Intervention;
use App\Models\Intervention\InterventionableIndividualService;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;

class A12 extends ReportQuery
{
    /**
     * Total servicii realizate în afara programului de lucru (în perioada de referință).
     */
    public static function query(): Builder
    {
        return Intervention::query()
            ->without('appointment', 'interventionable')
            ->leftJoin('interventionable_individual_services', 'interventions.interventionable_id', '=', 'interventionable_individual_services.id')
            ->whereHasMorph('interventionable', InterventionableIndividualService::class, function (Builder $query): void {
                $query
                    ->where('status', Status::REALIZED)
                    ->where('outside_working_hours', true);
            });
    }

    public static function dateColumn(): string
    {
        return 'interventionable_individual_services.date';
    }

    public static function aggregateByColumn(): string
    {
        return 'interventions.id';
    }

    public static function includeLatestBeforeRange(): bool
    {
        return false;
    }
}
