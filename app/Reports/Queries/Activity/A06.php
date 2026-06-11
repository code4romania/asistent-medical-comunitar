<?php

declare(strict_types=1);

namespace App\Reports\Queries\Activity;

use App\Models\Catagraphy;
use Illuminate\Database\Eloquent\Builder;
use Tpetry\QueryExpressions\Language\Alias;

/**
 * Total catagrafii nou-create în perioada de referință.
 */
class A06 extends ActivityQuery
{
    public static function query(): Builder
    {
        return Catagraphy::query()
            ->leftJoin('beneficiaries', 'beneficiaries.id', '=', 'catagraphies.beneficiary_id')
            ->leftJoin('users', 'users.id', '=', 'catagraphies.nurse_id')
            ->whereHasActivity(function (Builder $query) {
                $query
                    ->where('subject_type', 'catagraphy')
                    ->where('event', 'created');
            });
    }

    public static function tapQuery(Builder $query): Builder
    {
        return $query->addSelect([
            'catagraphies.nurse_id',
            new Alias('users.activity_county_id', 'county_id'),
        ]);
    }

    public static function dateColumn(string $type): string
    {
        return 'activity_log.created_at';
    }

    public static function aggregateByColumn(): string
    {
        return 'catagraphies.id';
    }

    public static function includeLatestBeforeRange(): bool
    {
        return false;
    }
}
