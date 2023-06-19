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
use Tpetry\QueryExpressions\Operator\Logical\CondAnd;
use Tpetry\QueryExpressions\Value\Value;

abstract class ReportFactory
{
    protected Report $report;

    protected Type $type;

    abstract protected function segmentByAge(string $value);

    abstract protected function segmentByGender(string $value);

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

        $segments = collect($this->report->segment_tuples)
            ->map(fn (array|string $segment) => static::countFilter($segment))
            ->all();

        return $this->report->indicators
            ->filter()
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
            ->pipe(function (Collection $collection) {
                $this->report->fill([
                    'title' => $this->report->title,
                    'data' => $collection->map(fn (array $data) => Arr::expandWith($data, '_')),
                ]);

                return $this->report->data;
            });
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
            ->map(function (object $data) {
                return Arr::except(
                    json_decode(json_encode($data), true),
                    ['status']
                );
            })
            ->all();
    }

    protected function countFilter(array|string $segment): Expression
    {
        $filter = collect($segment)
            ->mapWithKeys(function (string $segment) {
                [$key, $value] = explode('.', $segment);

                return [
                    $segment => match ($key) {
                        'age' => $this->segmentByAge($value),
                        'gender' => $this->segmentByGender($value),
                    },
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
