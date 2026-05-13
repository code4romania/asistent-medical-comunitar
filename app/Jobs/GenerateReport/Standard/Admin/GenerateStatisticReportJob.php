<?php

declare(strict_types=1);

namespace App\Jobs\GenerateReport\Standard\Admin;

use App\Jobs\GenerateReport\Standard\GenerateStandardReportJob;
use App\Models\County;
use App\Models\Report;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

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

        $this->generateDataset(
            $counties,
            fn (County $county): array => [
                'name' => "county-{$county->id}",
                'label' => $county->name,
            ],
            'county',
            'county_id',
            User::query()
                ->select('activity_county_id as county_id')
                ->whereColumn('users.id', DB::raw('ANY_VALUE(nurse_id)'))
                ->take(1),
        );
    }
}
