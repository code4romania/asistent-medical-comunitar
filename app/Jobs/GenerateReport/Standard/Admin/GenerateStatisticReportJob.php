<?php

declare(strict_types=1);

namespace App\Jobs\GenerateReport\Standard\Admin;

use App\Contracts\Enums\HasQuery;
use App\Jobs\GenerateReport\Standard\GenerateStandardReportJob;
use App\Models\County;
use App\Models\Report;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Tpetry\QueryExpressions\Function\Aggregate\Count;
use Tpetry\QueryExpressions\Language\Alias;

class GenerateStatisticReportJob extends GenerateStandardReportJob
{
    public Collection $counties;

    public function __construct(Report $report, array $data)
    {
        parent::__construct($report, $data);

        $this->counties = collect(data_get($data, 'counties'));
    }

    public function generate(): void
    {
        $counties = County::query()
            ->whereIn('id', $this->counties)
            ->get();

        $includeTotals = $counties->count() > 1;

        $this->report->data = [
            [
                'title' => $this->category->getLabel(),

                'columns' => $counties
                    ->map(fn (County $county) => [
                        'name' => "county-{$county->id}",
                        'label' => $county->name,
                    ])
                    ->when($includeTotals, fn (Collection $columns) => $columns->push([
                        'name' => 'total',
                        'label' => __('report.column.total'),
                    ]))
                    ->values(),

                'data' => $this->report->indicators()
                    ->mapWithKeys(function (HasQuery $indicator) use ($counties, $includeTotals) {
                        /** @var ReportQuery $reportQuery */
                        $reportQuery = $indicator->class();

                        $results = DB::query()
                            ->from($reportQuery::build($this->report))
                            ->select([
                                'county_id' => County::query()
                                    ->select('counties.id')
                                    ->join('users', 'users.activity_county_id', 'counties.id')
                                    ->whereColumn('users.id', 'nurse_id')
                                    ->take(1),
                                new Alias(new Count('id', distinct: true), 'count'),
                            ])
                            ->groupBy('county_id')
                            ->get()
                            ->pluck('count', 'county_id');

                        $total = 0;

                        return [
                            $indicator->getLabel() => $counties
                                ->mapWithKeys(function (County $county) use ($results, &$total) {
                                    $value = $results->get($county->id, 0);

                                    $total += $value;

                                    return [
                                        "county-{$county->id}" => $value,
                                    ];
                                })
                                ->when($includeTotals, fn (Collection $values) => $values->put('total', $total)),
                        ];
                    }),
            ],
        ];
    }
}
