<?php

declare(strict_types=1);

namespace App\Reports\Queries\Activity;

use App\Models\Report;
use App\Models\Vulnerability\Vulnerability;
use App\Models\Vulnerability\VulnerabilityEntry;
use App\Reports\Queries\ReportQuery;
use Illuminate\Contracts\Database\Query\Expression;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Number;
use Tpetry\QueryExpressions\Function\Aggregate\Avg;
use Tpetry\QueryExpressions\Function\Conditional\Coalesce;
use Tpetry\QueryExpressions\Language\Alias;
use Tpetry\QueryExpressions\Language\Cast;
use Tpetry\QueryExpressions\Operator\Arithmetic\Add;
use Tpetry\QueryExpressions\Value\Value;

class A08 extends ReportQuery
{
    /**
     * Număr mediu vulnerabilități per beneficiar în perioada de referință.
     */
    public static function query(): Builder
    {
        $sumExpression = new Alias(
            new Add(
                ...Vulnerability::cachedList()
                    ->filter(fn (Vulnerability $vulnerability): bool => $vulnerability->is_valid)
                    ->keys()
                    ->map(
                        fn (string $id): Expression => new Coalesce([
                            "map->{$id}",
                            new Value(0),
                        ])
                    )
            ),
            'vulnerabilities_count'
        );

        return VulnerabilityEntry::query()
            ->fromSub(
                VulnerabilityEntry::query()
                    ->select([
                        'id',
                        'created_at',
                        'beneficiary_id',
                        $sumExpression,
                    ]),
                'vulnerability_entries'
            )
            ->groupBy('beneficiary_id');
    }

    public static function dateColumn(string $type): string
    {
        return 'created_at';
    }

    public static function includeLatestBeforeRange(): bool
    {
        return false;
    }

    public static function aggregate(Report $report): mixed
    {
        $avg = static::build($report)
            ->select([
                'beneficiary_id',
                new Alias(
                    new Cast(new Avg('vulnerabilities_count'), 'float'),
                    'avg_vulnerabilities'
                ),
            ])
            ->get()
            ->groupBy('beneficiary_id')
            ->map->sum('avg_vulnerabilities')
            ->avg();

        return Number::format((float) $avg, 1);
    }
}
