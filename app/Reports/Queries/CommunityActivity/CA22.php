<?php

declare(strict_types=1);

namespace App\Reports\Queries\CommunityActivity;

use App\Enums\CommunityActivity\Administrative;
use App\Models\CommunityActivity;
use App\Reports\Queries\ReportQuery;
use Illuminate\Database\Eloquent\Builder;

/**
 * Total activități de tip Planificare activitate.
 */
class CA22 extends ReportQuery
{
    public static function query(): Builder
    {
        return CommunityActivity::query()
            ->whereAdministrativeActivity(Administrative::PLANNING);
    }

    public static function dateColumn(string $type): string
    {
        return 'date';
    }

    public static function includeLatestBeforeRange(): bool
    {
        return false;
    }
}
