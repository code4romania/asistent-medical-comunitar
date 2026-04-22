<?php

declare(strict_types=1);

namespace App\Reports\Queries\ServicesHealth;

use App\Models\Intervention;
use App\Models\Report;
use App\Models\Service\ServiceCategory;
use App\Reports\Queries\ReportQuery;
use Illuminate\Contracts\Database\Query\Expression;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Tpetry\QueryExpressions\Function\Aggregate\Count;
use Tpetry\QueryExpressions\Function\Aggregate\CountFilter;
use Tpetry\QueryExpressions\Function\Comparison\StrListContains;
use Tpetry\QueryExpressions\Function\Conditional\Coalesce;
use Tpetry\QueryExpressions\Language\Alias;
use Tpetry\QueryExpressions\Value\Value;

abstract class ServicesHealthQuery extends ReportQuery
{
    public static string $vulnerability;

    public static string $secondaryVulnerability;

    public static bool $countBeneficiaries = false;

    public static function query(): Builder
    {
        return Intervention::query()
            ->withoutEagerLoads()
            ->when(isset(static::$vulnerability), fn (Builder $query) => $query->whereVulnerability(static::$vulnerability))
            ->when(isset(static::$secondaryVulnerability), fn (Builder $query) => $query->whereSecondaryVulnerability(static::$secondaryVulnerability))
            ->onlyRealized()
            ->leftJoin('interventionable_individual_services', 'interventionable_individual_services.id', 'interventions.interventionable_id')
            ->leftJoin('services', 'interventionable_individual_services.service_id', 'services.id');
    }

    public static function dateColumn(string $type): string
    {
        return 'interventions.created_at';
    }

    public static function includeLatestBeforeRange(): bool
    {
        return false;
    }

    public static function distinct(): bool
    {
        return false;
    }

    public static function aggregate(Report $report): mixed
    {
        $categories = ServiceCategory::query()
            ->with('services:id,category_id')
            ->get()
            ->mapWithKeys(fn (ServiceCategory $category): array => [
                Str::slug($category->name) => $category
                    ->services
                    ->pluck('id')
                    ->join(','),
            ]);

        return static::build($report, true)
            ->select([
                static::countTotal(),
                static::countFilterCategory('educatie-pentru-sanatate', $categories),
                static::countFilterCategory('trimitere-referire', $categories),
                static::countFilterCategory('notificare-apelare-programare', $categories),
                static::countFilterCategory('insotire', $categories),
                static::countFilterCategory('tratament-ingrijiri', $categories),
                static::countFilterCategory('monitorizare-testare', $categories),
                static::countFilterCategory('sprijin', $categories),
                static::countFilterCategory('activitati-nespecifice-amc', $categories),
            ])
            ->first()
            ->toArray();
    }

    protected static function countTotal(): Expression
    {
        $expression = static::$countBeneficiaries
            ? new Count('DISTINCT beneficiary_id')
            : new Count('*');

        return new Alias(
            $expression,
            'total',
        );
    }

    protected static function countFilterCategory(string $name, Collection $categories): Expression
    {
        $expression = static::$countBeneficiaries
            ? new CountFilter(
                new StrListContains(new Value($categories->get($name)), 'interventionable_individual_services.service_id'),
                distinct: true,
                column: 'beneficiary_id',
            )
            : new CountFilter(
                new StrListContains(new Value($categories->get($name)), 'interventionable_individual_services.service_id')
            );

        return new Alias(
            new Coalesce([
                $expression,
                new Value(0),
            ]),
            $name,
        );
    }
}
