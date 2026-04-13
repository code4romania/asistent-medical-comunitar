<?php

declare(strict_types=1);

namespace App\Reports\Queries\Activity;

use App\Models\Catagraphy;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;

class A06 extends ReportQuery
{
    /**
     * Total catagrafii nou-create în perioada de referință.
     */
    public static function query(): Builder
    {
        return Catagraphy::query()
            ->whereHasActivity(function (Builder $query) {
                $query
                    ->where('subject_type', 'catagraphy')
                    ->where('event', 'created');
            });
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
