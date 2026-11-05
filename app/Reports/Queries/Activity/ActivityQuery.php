<?php

declare(strict_types=1);

namespace App\Reports\Queries\Activity;

use App\Reports\Queries\ReportQuery;
use Tpetry\QueryExpressions\Language\Alias;

abstract class ActivityQuery extends ReportQuery
{
    public static function selectColumns(): array
    {
        return [
            new Alias(static::aggregateByColumn(), 'id'),
        ];
    }
}
