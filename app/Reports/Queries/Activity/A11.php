<?php

declare(strict_types=1);

namespace App\Reports\Queries\Activity;

use App\Enums\Gender;
use App\Enums\Intervention\Status;
use App\Models\Beneficiary;
use Illuminate\Database\Eloquent\Builder;

/**
 * Total femei cărora li s-au oferit servicii în perioada de referință.
 */
class A11 extends ActivityQuery
{
    public static function query(): Builder
    {
        return Beneficiary::query()
            ->where('gender', Gender::FEMALE)
            ->rightJoin('interventions', 'beneficiaries.id', '=', 'interventions.beneficiary_id')
            ->leftJoin('interventionable_individual_services', 'interventions.interventionable_id', '=', 'interventionable_individual_services.id')
            ->where('interventionable_individual_services.status', '=', Status::REALIZED);
    }

    public static function dateColumn(string $type): string
    {
        return 'interventionable_individual_services.date';
    }

    public static function aggregateByColumn(): string
    {
        return 'beneficiaries.id';
    }

    public static function includeLatestBeforeRange(): bool
    {
        return false;
    }
}
