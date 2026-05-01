<?php

declare(strict_types=1);

namespace App\Reports\Queries\Interventions;

use App\Models\Intervention;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;

abstract class InterventionsQuery extends ReportQuery
{
    public static function query(): Builder
    {
        return Intervention::query()
            ->withoutEagerLoads()
            ->leftJoin('beneficiaries', 'interventions.beneficiary_id', '=', 'beneficiaries.id');
    }

    public static function selectColumns(): array
    {
        return [
            'interventions.id',
            'interventions.created_at',
        ];
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
