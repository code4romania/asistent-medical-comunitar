<?php

declare(strict_types=1);

namespace App\Jobs\GenerateReport\Standard\Admin;

use App\Jobs\GenerateReport\Standard\GenerateStandardReportJob;
use App\Models\Report;
use Exception;
use Illuminate\Support\Collection;

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
        throw new Exception('Not implemented');
    }
}
