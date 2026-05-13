<?php

declare(strict_types=1);

namespace App\Reports\Queries\Activity;

use App\Models\Beneficiary;
use Illuminate\Database\Eloquent\Builder;
use Tpetry\QueryExpressions\Language\Alias;

abstract class BeneficiaryStatusQuery extends ActivityQuery
{
    public static function query(): Builder
    {
        return Beneficiary::query()
            ->fromSub(
                Beneficiary::query()
                    ->select([
                        'beneficiaries.id',
                        'beneficiaries.nurse_id',
                        'beneficiaries.county_id',
                        'activity_log.created_at',
                        new Alias('properties->attributes->status', 'status'),
                    ])
                    ->whereHasActivity(function (Builder $query) {
                        $query
                            ->where('log_name', 'default')
                            ->where('event', 'updated')
                            ->whereJsonContainsKey('properties->attributes->status');
                    }),
                'beneficiaries'
            );
    }

    public static function dateColumn(string $type): string
    {
        return 'created_at';
    }
}
