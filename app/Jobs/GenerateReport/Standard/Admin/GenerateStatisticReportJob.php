<?php

declare(strict_types=1);

namespace App\Jobs\GenerateReport\Standard\Admin;

use App\Contracts\Enums\HasQuery;
use App\Jobs\GenerateReport\Standard\GenerateStandardReportJob;
use App\Models\County;
use App\Models\Report;
use Illuminate\Support\Collection;
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

        $this->report->data = [
            [
                'title' => $this->getCategory()->label(),

                'columns' => $counties
                    ->map(fn (County $county) => [
                        'name' => "county-{$county->id}",
                        'label' => $county->name,
                    ])
                    ->values(),

                'data' => $this->report->indicators()
                    ->mapWithKeys(function (HasQuery $indicator) use ($counties) {
                        /** @var ReportQuery $reportQuery */
                        $reportQuery = $indicator->class();

                        $results = $reportQuery::build($this->report)
                            ->select([
                                'county_id' => County::query()
                                    ->select('counties.id')
                                    ->join('users', 'users.activity_county_id', 'counties.id')
                                    ->whereColumn('users.id', 'nurse_id')
                                    ->take(1),
                                new Alias(new Count('*'), 'count'),
                            ])
                            ->groupBy('county_id')
                            ->toBase()
                            ->get()
                            ->pluck('count', 'county_id');

                        return [
                            $indicator->label() => $counties->mapWithKeys(fn (County $county) => [
                                "county-{$county->id}" => $results->get($county->id, 0),
                            ]),
                        ];
                    }),
            ],
        ];
    }
}
