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
use Tpetry\QueryExpressions\Function\Conditional\Coalesce;
use Tpetry\QueryExpressions\Language\Alias;
use Tpetry\QueryExpressions\Operator\Comparison\Equal;
use Tpetry\QueryExpressions\Value\Value;

abstract class ServicesHealthQuery extends ReportQuery
{
    public static array|string $vulnerability;

    public static array|string $secondaryVulnerability;

    public static bool $countBeneficiaries = false;

    private static Collection $serviceCategories;

    public static function query(): Builder
    {
        return Intervention::query()
            ->withoutEagerLoads()
            ->when(isset(static::$vulnerability), fn (Builder $query) => $query->whereVulnerability(static::$vulnerability))
            ->when(isset(static::$secondaryVulnerability), fn (Builder $query) => $query->whereSecondaryVulnerability(static::$secondaryVulnerability))
            ->onlyRealized()
            ->leftJoin('interventionable_individual_services', 'interventionable_individual_services.id', 'interventions.interventionable_id')
            ->leftJoin('services', 'interventionable_individual_services.service_id', 'services.id')
            ->leftJoin('service_categories', 'services.category_id', 'service_categories.id');
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
        static::$serviceCategories = ServiceCategory::query()
            ->get()
            ->mapWithKeys(fn (ServiceCategory $category): array => [
                Str::slug($category->name) => $category->id,
            ])
            ->filter(fn (int $id, string $slug) => \in_array($slug, [
                'educatie-pentru-sanatate',
                'trimitere-referire',
                'notificare-apelare-programare',
                'insotire',
                'tratament-ingrijiri',
                'monitorizare-testare',
                'sprijin',
                'activitati-nespecifice-amc',
            ]));

        if (static::$countBeneficiaries) {
            $total = [
                'total' => static::build($report, true)
                    ->select([
                        new Alias(new Count('beneficiary_id', true), 'total'),
                    ])
                    ->first()
                    ->total,
            ];

            $result = static::build($report, true)
                ->select([
                    new Alias(new Count('beneficiary_id', true), 'total'),
                    'category_id',
                ])
                ->groupBy('category_id')
                ->get()
                ->mapWithKeys(function (Intervention $intervention) {
                    $category = static::$serviceCategories->search($intervention->category_id);

                    return [$category => $intervention->total];
                })
                ->toArray();

            $defaults = static::$serviceCategories->keys()
                ->mapWithKeys(fn (string $name) => [$name => 0])
                ->toArray();

            return array_merge(
                $total,
                $defaults,
                $result
            );
        }

        return static::build($report, true)
            ->select([
                new Alias(new Count('*'), 'total'),
                static::countFilter('educatie-pentru-sanatate'),
                static::countFilter('trimitere-referire'),
                static::countFilter('notificare-apelare-programare'),
                static::countFilter('insotire'),
                static::countFilter('tratament-ingrijiri'),
                static::countFilter('monitorizare-testare'),
                static::countFilter('sprijin'),
                static::countFilter('activitati-nespecifice-amc'),
            ])
            ->first()
            ->toArray();
    }

    protected static function countFilter(string $name): Expression
    {
        return new Alias(
            new Coalesce([
                new CountFilter(
                    new Equal('service_categories.id', new Value(static::$serviceCategories->get($name)))
                ),
                new Value(0),
            ]),
            $name,
        );
    }
}
