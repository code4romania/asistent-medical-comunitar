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
            ->leftJoin('service_categories', 'services.category_id', 'service_categories.id')
            ->leftJoin('beneficiaries', 'interventions.beneficiary_id', 'beneficiaries.id');
    }

    public static function selectColumns(): array
    {
        return [
            'interventions.id',
            'interventions.created_at',
        ];
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
        static::loadServiceCategories();

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
                ...static::categoryCountFilters(),
            ])
            ->first()
            ->toArray();
    }

    /**
     * Returns a Collection keyed by segment ID (nurse_id or county_id).
     * Each value has the same shape as aggregate(): total + one key per service category.
     *
     * @return Collection<int|string, array<string, int>>
     */
    public static function groupedAggregate(Report $report, string $column, ?Builder $query = null): mixed
    {
        static::loadServiceCategories();

        if (static::$countBeneficiaries) {
            return static::groupedAggregateBeneficiaries($report, $column, $query);
        }

        return static::groupedAggregateServices($report, $column, $query);
    }

    private static function groupedAggregateServices(Report $report, string $column, ?Builder $query): Collection
    {
        $select = [
            new Alias(new Count('*'), 'total'),
            ...static::categoryCountFilters(),
        ];

        if (\is_null($query)) {
            $select[] = $column;
        } else {
            $select[$column] = $query;
        }

        return static::build($report, true)
            ->select($select)
            ->groupBy($column)
            ->get()
            ->mapWithKeys(fn (Intervention $row): array => [
                $row->$column => collect($row->toArray())->except($column)->toArray(),
            ]);
    }

    private static function groupedAggregateBeneficiaries(Report $report, string $column, ?Builder $query): Collection
    {
        $totalSelect = [new Alias(new Count('beneficiary_id', true), 'total')];

        if (\is_null($query)) {
            $totalSelect[] = $column;
        } else {
            $totalSelect[$column] = $query;
        }

        $totals = static::build($report, true)
            ->select($totalSelect)
            ->groupBy($column)
            ->pluck('total', $column);

        $catSelect = [
            new Alias(new Count('beneficiary_id', true), 'total'),
            'category_id',
        ];

        if (\is_null($query)) {
            $catSelect[] = $column;
        } else {
            $catSelect[$column] = $query;
        }

        $categoryRows = static::build($report, true)
            ->select($catSelect)
            ->groupBy('category_id', $column)
            ->get()
            ->groupBy($column);

        $defaults = static::$serviceCategories->keys()
            ->mapWithKeys(fn (string $name): array => [$name => 0])
            ->toArray();

        return $totals->keys()->mapWithKeys(
            function (mixed $segmentId) use ($totals, $categoryRows, $defaults): array {
                $perCategory = $categoryRows
                    ->get($segmentId, collect())
                    ->mapWithKeys(function (Intervention $row): array {
                        $cat = static::$serviceCategories->search($row->category_id);

                        return $cat ? [$cat => $row->total] : [];
                    })
                    ->toArray();

                return [
                    $segmentId => array_merge(
                        ['total' => $totals->get($segmentId, 0)],
                        $defaults,
                        $perCategory,
                    ),
                ];
            }
        );
    }

    private static function loadServiceCategories(): void
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
    }

    private static function categoryCountFilters(): array
    {
        return [
            static::countFilter('educatie-pentru-sanatate'),
            static::countFilter('trimitere-referire'),
            static::countFilter('notificare-apelare-programare'),
            static::countFilter('insotire'),
            static::countFilter('tratament-ingrijiri'),
            static::countFilter('monitorizare-testare'),
            static::countFilter('sprijin'),
            static::countFilter('activitati-nespecifice-amc'),
        ];
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
