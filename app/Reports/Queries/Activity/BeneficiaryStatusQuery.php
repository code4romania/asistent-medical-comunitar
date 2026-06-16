<?php

declare(strict_types=1);

namespace App\Reports\Queries\Activity;

use App\Models\Beneficiary;
use Illuminate\Contracts\Database\Query\Expression;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
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
                        'activity_log.created_at',
                        new Alias('properties->attributes->status', 'status'),
                        static::rankedPartition(),
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

    public static function rankedLatestBeforeRange(): bool
    {
        return true;
    }

    public static function rankedPartition(): Expression
    {
        return DB::raw('LEAD(activity_log.created_at) OVER (PARTITION BY beneficiaries.id ORDER BY activity_log.created_at ASC) as next_created_at');
    }
}
