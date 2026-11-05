<?php

declare(strict_types=1);

namespace App\Reports\Queries\Activity;

use App\Reports\Queries\InterventionReportQuery;
use Tpetry\QueryExpressions\Language\Alias;

abstract class ActivityInterventionQuery extends InterventionReportQuery
{
    public static function selectColumns(): array
    {
        return [
            new Alias(static::aggregateByColumn(), 'id'),
        ];
    }
}
