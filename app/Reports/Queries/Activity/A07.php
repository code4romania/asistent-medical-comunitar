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
            ->whereHasActivity(function (Builder $query) {
                $query
                    ->where('subject_type', 'catagraphy')
                    ->where('event', 'updated');
            });
    }

    public static function tapQuery(Builder $query): Builder
    {
        return $query->addSelect([
            'catagraphies.nurse_id',
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
