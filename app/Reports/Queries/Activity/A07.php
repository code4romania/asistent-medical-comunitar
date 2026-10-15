<?php

declare(strict_types=1);

namespace App\Reports\Queries\Activity;

use App\Models\Catagraphy;
use Illuminate\Database\Eloquent\Builder;

/**
 * Total catagrafii actualizate în perioada de referință.
 */
class A07 extends ActivityQuery
{
    public static function query(): Builder
    {
        return Catagraphy::query()
            ->leftJoin('beneficiaries', 'beneficiaries.id', '=', 'catagraphies.beneficiary_id')
            ->leftJoin('users', 'users.id', '=', 'catagraphies.nurse_id')
            ->whereHasActivity(function (Builder $query) {
                $query
                    ->where('subject_type', 'catagraphy')
                    ->where('event', 'updated');
            })
            ->distinct();
    }

    public static function segmentColumns(): array
    {
        return [
            'nurse_id' => 'catagraphies.nurse_id',
            'county_id' => 'users.activity_county_id',
        ];
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
