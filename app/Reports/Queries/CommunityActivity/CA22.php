<?php

declare(strict_types=1);

namespace App\Reports\Queries\CommunityActivity;

use App\Enums\CommunityActivity\Administrative;
use Illuminate\Database\Eloquent\Builder;

/**
 * Total activități de tip Planificare activitate.
 */
class CA22 extends CommunityActivityQuery
{
    public static function query(): Builder
    {
        return parent::query()
            ->whereAdministrativeActivity(Administrative::PLANNING);
    }
}
