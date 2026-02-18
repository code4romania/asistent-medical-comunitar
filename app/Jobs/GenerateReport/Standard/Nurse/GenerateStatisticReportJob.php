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
                'title' => $this->report->category->getLabel(),
                'data' => $this->report->getIndicators()
                    ->mapWithKeys(function (HasQuery $indicator) {
                        /** @var ReportQuery $reportQuery */
                        $reportQuery = $indicator->class();

                        return [
                            $indicator->getLabel() => [
                                $reportQuery::aggregate($this->report),
                            ],
                        ];
                    }),
            ],
        ];
    }
}
