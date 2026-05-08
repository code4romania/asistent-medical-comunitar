<?php

declare(strict_types=1);

namespace App\Jobs\GenerateReport\Standard;

use App\Contracts\Enums\HasQuery;
use App\Enums\Report\Standard\Category;
use App\Enums\Report\Status;
use App\Enums\Report\Type;
use App\Models\Report;
use App\Reports\Queries\ReportQuery;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Illuminate\Support\Number;
use Throwable;

abstract class GenerateStandardReportJob implements ShouldQueue, ShouldBeUnique
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Delete the job when models are missing.
     *
     * @var bool
     */
    public bool $deleteWhenMissingModels = true;

    public Report $report;

    public function uniqueId(): string
    {
        return "generate-report:{$this->report->id}";
    }

    /**
     * Create a new job instance.
     */
    public function __construct(Report $report, array $data)
    {
        $this->report = $report;
    }

    abstract public function generate(): void;

    public function handle(): void
    {
        rescue(function () {
            $this->generate();

            $this->report->status = Status::FINISHED;
        }, function (Throwable $e) {
            $this->report->status = Status::FAILED;

            $this->fail($e);
        });

        $this->report->save();
    }

    protected function addToTotal(int|float &$total, mixed $value): void
    {
        if (\is_string($value)) {
            $value = Number::parseFloat($value);
        }

        $total += $value;
    }

    protected function generateDataset(Collection $segments, callable $segmentColumns, string $segmentName, string $groupedAggregateColumn, ?Builder $groupedAggregateQuery = null): void
    {
        $includeTotals = $segments->count() > 1;

        if ($this->report->category->is(Category::SERVICES_HEALTH)) {
            $this->report->data = $this->report->getIndicators()
                ->map(function (HasQuery $indicator) use ($segments, $segmentColumns, $includeTotals, $groupedAggregateColumn, $groupedAggregateQuery): array {
                    /** @var ReportQuery $reportQuery */
                    $reportQuery = $indicator->class();

                    $results = $reportQuery::groupedAggregate(
                        $this->report,
                        $groupedAggregateColumn,
                        $groupedAggregateQuery
                    );

                    $columns = $this->report->category->getColumns(Type::STATISTIC, $this->report->user->role);

                    $defaults = collect($columns)
                        ->mapWithKeys(fn (array $col): array => [$col['name'] => 0])
                        ->toArray();

                    $data = $segments->mapWithKeys(function (Model $segment) use ($results, $segmentColumns, $defaults): array {
                        $label = data_get($segmentColumns($segment), 'label');

                        return [$label => $results->get($segment->id, $defaults)];
                    });

                    if ($includeTotals) {
                        $totals = $defaults;

                        foreach ($results as $row) {
                            foreach ($row as $key => $value) {
                                $this->addToTotal($totals[$key], $value);
                            }
                        }

                        $data->put(__('report.column.total'), $totals);
                    }

                    return [
                        'title' => $indicator->getLabel(),
                        'columns' => $columns,
                        'data' => $data->toArray(),
                    ];
                })
                ->values();

            return;
        }

        $this->report->data = [
            [
                'title' => $this->report->category->getLabel(),

                'columns' => $segments
                    ->map($segmentColumns)
                    ->when($includeTotals, fn (Collection $columns) => $columns->push([
                        'name' => 'total',
                        'label' => __('report.column.total'),
                    ]))
                    ->values(),

                'data' => $this->report->getIndicators()
                    ->mapWithKeys(function (HasQuery $indicator) use ($segments, $includeTotals, $segmentName, $groupedAggregateColumn, $groupedAggregateQuery): array {
                        /** @var ReportQuery $reportQuery */
                        $reportQuery = $indicator->class();

                        $results = $reportQuery::groupedAggregate(
                            $this->report,
                            $groupedAggregateColumn,
                            $groupedAggregateQuery
                        );

                        $total = 0;

                        return [
                            $indicator->getLabel() => $segments
                                ->mapWithKeys(function (Model $segment) use ($results, &$total, $segmentName) {
                                    $value = $results->get($segment->id, 0);

                                    $this->addToTotal($total, $value);

                                    return [
                                        "{$segmentName}-{$segment->id}" => $value,
                                    ];
                                })
                                ->when($includeTotals, fn (Collection $values) => $values->put(
                                    'total',
                                    $reportQuery::computeTotal(
                                        $total,
                                        $segments->count()
                                    )
                                )),
                        ];
                    }),
            ],
        ];
    }
}
