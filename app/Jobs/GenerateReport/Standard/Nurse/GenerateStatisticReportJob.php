<?php

declare(strict_types=1);

namespace App\Jobs\GenerateReport\Standard\Nurse;

use App\Contracts\Enums\HasQuery;
use App\Jobs\GenerateReport\Standard\GenerateStandardReportJob;
use App\Reports\Queries\ReportQuery;

class GenerateStatisticReportJob extends GenerateStandardReportJob
{
    public function generate(): void
    {
        $this->report->data = [
            [
                'title' => $this->getCategory()->label(),
                'data' => $this->report->indicators()
                    ->mapWithKeys(function (HasQuery $indicator) {
                        /** @var ReportQuery $reportQuery */
                        $reportQuery = $indicator->class();

                        return [
                            $indicator->label() => [
                                $reportQuery::build($this->report)
                                    ->distinct('id')
                                    ->count('id'),
                            ],
                        ];
                    }),
            ],
        ];
    }
}
