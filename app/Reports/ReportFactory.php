<?php

declare(strict_types=1);

namespace App\Reports;

use App\Models\Report;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

abstract class ReportFactory
{
    protected Report $report;

    protected array $header = [];

    protected array $rows = [];

    abstract public function getName(): string;

    public function __construct(Report $report)
    {
        $this->report = $report;
    }

    public static function make(Report $report): static
    {
        return app(static::class, ['report' => $report]);
    }

    final public function handle(): Collection
    {
        if ($this->report->data !== null) {
            return $this->report->data;
        }

        return $this->report->indicators
            ->map(function (array $values, string $indicator) {
                $method = Str::of("query-{$indicator}")
                    ->slug()
                    ->camel()
                    ->value();

                if (! method_exists($this, $method)) {
                    throw new Exception("Method {$method} does not exists");
                }

                return $this->$method($values);
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

    public function getTitle(): string
    {
        $title = [
            $this->getName(),
        ];

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

    public function runQueryFor(string $model, array $select = []): array
    {
        $results = $model::query()
            ->when($this->report->date_from, function (Builder $query, Carbon $date) {
                $query->whereDate('created_at', '>=', $date);
            })
            ->when($this->report->date_until, function (Builder $query, Carbon $date) {
                $query->whereDate('created_at', '<=', $date);
            })
            ->when($select, function (Builder $query, array $select) {
                $query->select($select);
            })
            ->toBase()
            ->first();

        return collect($results)
            ->map(fn ($values) => Arr::map(Arr::wrap($values), 'floatval'))
            ->all();
    }
}
