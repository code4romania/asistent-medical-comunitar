<?php

declare(strict_types=1);

namespace App\Jobs\GenerateReport\Standard\Coordinator;

use App\Contracts\Enums\HasQuery;
use App\Jobs\GenerateReport\Standard\GenerateStandardReportJob;
use App\Models\Report;
use App\Models\User;
use App\Reports\Queries\ReportQuery;
use Illuminate\Support\Collection;
use Tpetry\QueryExpressions\Function\Aggregate\Count;
use Tpetry\QueryExpressions\Language\Alias;

class GenerateStatisticReportJob extends GenerateStandardReportJob
{
    public Collection $nurses;

    public function __construct(Report $report, array $data)
    {
        parent::__construct($report, $data);

        $this->nurses = collect(data_get($data, 'nurses'));
    }

    public function generate(): void
    {
        $nurses = User::query()
            ->onlyNurses()
            ->activatesInCounty($this->report->user->county_id)
            ->withActivityAreas()
            ->whereIn('id', $this->nurses)
            ->get(['id',  'full_name', 'activity_county_id']);

        $includeTotals = $nurses->count() > 1;

        $this->report->data = [
            [
                'title' => $this->getCategory()->label(),

                'columns' => $nurses
                    ->map(fn (User $nurse) => [
                        'name' => "nurse-{$nurse->id}",
                        'label' => $nurse->full_name,
                        'suffix' => $nurse->activityCities
                            ->pluck('name')
                            ->join(', '),
                    ])
                    ->when($includeTotals, fn (Collection $columns) => $columns->push([
                        'name' => 'total',
                        'label' => __('report.column.total'),
                    ]))
                    ->values(),

                'data' => $this->report->indicators()
                    ->mapWithKeys(function (HasQuery $indicator) use ($nurses, $includeTotals) {
                        /** @var ReportQuery $reportQuery */
                        $reportQuery = $indicator->class();

                        $results = $reportQuery::build($this->report)
                            ->select('nurse_id', new Alias(new Count('*'), 'count'))
                            ->groupBy('nurse_id')
                            ->toBase()
                            ->get()
                            ->pluck('count', 'nurse_id');

                        $total = 0;

                        return [
                            $indicator->label() => $nurses
                                ->mapWithKeys(function (User $nurse) use ($results, $total) {
                                    $value = $results->get($nurse->id, 0);

                                    $total += $value;

                                    return [
                                        "nurse-{$nurse->id}" => $value,
                                    ];
                                })
                                ->when($includeTotals, fn (Collection $values) => $values->put('total', $total)),
                        ];
                    }),
            ],
        ];
    }
}
