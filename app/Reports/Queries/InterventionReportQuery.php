<?php

declare(strict_types=1);

namespace App\Reports\Queries;

use App\Models\Intervention;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

/**
 * Credits interventions to their author rather than to the beneficiary's current nurse.
 */
abstract class InterventionReportQuery extends ReportQuery
{
    public static function query(): Builder
    {
        return Intervention::query()
            ->withoutEagerLoads()
            ->leftJoin('beneficiaries', 'interventions.beneficiary_id', '=', 'beneficiaries.id');
    }

    public static function segmentColumns(): array
    {
        return [
            'nurse_id' => 'interventions.user_id',
            'county_id' => static::toExpression(
                DB::table('users')
                    ->select('users.activity_county_id')
                    ->whereColumn('users.id', 'interventions.user_id')
                    ->limit(1)
            ),
        ];
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
