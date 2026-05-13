<?php

declare(strict_types=1);

namespace App\Jobs\GenerateReport\Standard\Coordinator;

use App\Jobs\GenerateReport\Standard\GenerateStandardReportJob;
use App\Models\Report;
use App\Models\User;
use Illuminate\Support\Collection;

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

        $this->generateDataset(
            $nurses,
            fn (User $nurse): array => [
                'name' => "nurse-{$nurse->id}",
                'label' => $nurse->full_name,
                'suffix' => $nurse->activityCities
                    ->pluck('name')
                    ->join(', '),
            ],
            'nurse',
            'nurse_id',
        );
    }
}
