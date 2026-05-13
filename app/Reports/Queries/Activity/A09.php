<?php

declare(strict_types=1);

namespace App\Reports\Queries\Activity;

use App\Models\Intervention;
use Illuminate\Database\Eloquent\Builder;

/**
 * Total servicii realizate în perioada de referință.
 */
class A09 extends ActivityQuery
{
    public static function query(): Builder
    {
        return Intervention::query()
            ->withoutEagerLoads()
            ->leftJoin('interventionable_individual_services', 'interventions.interventionable_id', '=', 'interventionable_individual_services.id')
            ->leftJoin('beneficiaries', 'interventions.beneficiary_id', '=', 'beneficiaries.id')
            ->onlyRealized();
    }

    public static function dateColumn(string $type): string
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
