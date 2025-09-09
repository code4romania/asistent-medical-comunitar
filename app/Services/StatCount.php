<?php

declare(strict_types=1);

namespace App\Services;

use Tpetry\QueryExpressions\Function\Aggregate\CountFilter;
use Tpetry\QueryExpressions\Function\Conditional\Coalesce;
use Tpetry\QueryExpressions\Language\Alias;
use Tpetry\QueryExpressions\Operator\Comparison\Between;
use Tpetry\QueryExpressions\Value\Value;

class StatCount
{
    public static function comparedBy(string $column): array
    {
        $today = today()->toDateString();
        $oneMonthAgo = today()->subMonth()->toDateString();
        $twoMonthsAgo = today()->subMonths(2)->toDateString();

        return [
            new Alias(
                new Coalesce([
                    new CountFilter(new Between($column, new Value($oneMonthAgo), new Value($today))),
                    new Value(0),
                ]),
                'current'
            ),

            new Alias(
                new Coalesce([
                    new CountFilter(new Between($column, new Value($twoMonthsAgo), new Value($oneMonthAgo))),
                    new Value(0),
                ]),
                'previous'
            ),
        ];
    }
}
