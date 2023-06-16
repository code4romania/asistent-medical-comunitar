<?php

declare(strict_types=1);

namespace App\Reports;

use App\Enums\Report\Type;
use App\Models\Report;
use Closure;
use Exception;
use Illuminate\Contracts\Database\Query\Expression;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Tpetry\QueryExpressions\Function\Aggregate\CountFilter;
use Tpetry\QueryExpressions\Function\Conditional\Coalesce;
use Tpetry\QueryExpressions\Language\Alias;
use Tpetry\QueryExpressions\Operator\Comparison\Equal;
use Tpetry\QueryExpressions\Operator\Logical\CondAnd;
use Tpetry\QueryExpressions\Value\Value;

abstract class ReportFactory
{
    protected Report $report;

    protected Type $type;

    public function __construct(Report $report)
    {
        $this->report = $report;
    }

    public static function make(Report $report)
    {
        $static = app(static::class, ['report' => $report]);
        $static->handle();

        return $static;
    }

    public function getName(): string
    {
        return $this->type->label();
    }

    public function getTitle(): string
    {
        $title = [
            $this->getName(),
        ];

        if ($this->report->segments->isNotEmpty()) {
            $title[] = __('report.title.segments', [
                'segments' => $this->report->segments
                    ->filter()
                    ->keys()
                    ->map(fn (string $segment) => Str::lower(__("report.column.{$segment}")))
                    ->implode(', '),
            ]);
        }

        if ($this->report->date_until === null) {
            $title[] = __('report.title.date', [
                'date' => $this->report->date_from->toFormattedDate(),
            ]);
        } else {
            $title[] = __('report.title.date_range', [
                'from' => $this->report->date_from->toFormattedDate(),
                'to' => $this->report->date_until->toFormattedDate(),
            ]);
        }

        return implode(' ', $title);
    }

    public function getHeader(): ?array
    {
        $segments = $this->report->segments
            ->filter();

        if ($segments->isEmpty()) {
            return null;
        }

        if ($segments->has('age') && $segments->has('gender')) {
            return [
                'supra' => [
                    'segment' => 'age',
                    'columns' => $segments->get('age'),
                ],
                'main' => [
                    'segment' => 'gender',
                    'columns' => $segments->get('gender'),
                ],
            ];
        } else {
            return [
                'supra' => [],
                'main' => [
                    'segment' => $segments->keys()->first(),
                    'columns' => $segments->first(),
                ],
            ];
        }
    }

    final protected function handle(): Collection
    {
        if ($this->report->data !== null) {
            return $this->report->data;
        }

        $segments = $this->prepareSegments();

        return $this->report->indicators
            ->map(function (array $values, string $indicator) use ($segments) {
                $method = Str::of("query-{$indicator}")
                    ->slug()
                    ->camel()
                    ->value();

                if (! method_exists($this, $method)) {
                    throw new Exception("Method {$method} does not exists");
                }

                return $this->$method($values, $segments);
            })
            ->flatMap(function (array $values, string $indicator) {
                return Arr::prependKeysWith($values, $indicator . '.');
            })
            ->tap(function (Collection $data) {
                $this->report->fill([
                    'title' => $this->getTitle(),
                    'data' => $data,
                ]);
            });
    }

    protected function prepareSegments(): array
    {
        $segments = $this->report->segments
            ->map(function (array $values, string $indicator) {
                return collect($values)
                    ->map(fn ($value) => $indicator . '.' . $value)
                    ->all();
            })
            ->filter()
            ->values()
            ->all();

        return Arr::crossJoin(...$segments);
    }

    protected function runQueryFor(string $model, Closure $callback): array
    {
        return $model::query()
            ->when($this->report->date_from, function (Builder $query, Carbon $date) {
                $query->whereDate('beneficiaries.created_at', '>=', $date);
            })
            ->when($this->report->date_until, function (Builder $query, Carbon $date) {
                $query->whereDate('beneficiaries.created_at', '<=', $date);
            })
            ->tap($callback)
            ->toBase()
            ->get()
            ->collect()
            ->keyBy('status')
            ->all();
    }

    protected function countFilter(array|string $segment): Expression
    {
        $filter = collect($segment)
            ->mapWithKeys(function (string $segment) {
                [$key, $value] = explode('.', $segment);

                $method = Str::of("expression-{$key}-{$value}")
                    ->slug()
                    ->camel()
                    ->value();

                if (method_exists($this, $method)) {
                    return [
                        $segment => $this->$method($value),
                    ];
                }

                return [
                    $segment => new Equal($key, match ($value) {
                        'total' => $key,
                        default => new Value($value),
                    }),
                ];
            });

        return new Alias(
            new Coalesce([
                new CountFilter($filter->reduce(function (?Expression $result, Expression $value) {
                    if ($result instanceof Expression) {
                        return new CondAnd($result, $value);
                    }

                    return $value;
                })),
                new Value(0),
            ]),
            $filter->keys()
                ->map(
                    fn (string $key) => Str::of($key)
                        ->afterLast('.')
                        ->slug()
                )
                ->implode('_')
        );
    }
}
