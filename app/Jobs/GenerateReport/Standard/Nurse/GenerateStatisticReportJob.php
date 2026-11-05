<?php

declare(strict_types=1);

namespace App\Jobs\GenerateReport\Standard\Nurse;

use App\Contracts\Enums\HasQuery;
use App\Enums\Report\Type;
use App\Jobs\GenerateReport\Standard\GenerateStandardReportJob;
use App\Reports\Queries\ReportQuery;
use Illuminate\Support\Arr;

class GenerateStatisticReportJob extends GenerateStandardReportJob
{
    public function generate(): void
    {
        $this->report->data = [
            [
                'title' => $this->report->category->getLabel(),
                'columns' => $this->report->category->getColumns(Type::STATISTIC, $this->report->user->role),
                'data' => $this->report->getIndicators()
                    ->mapWithKeys(function (HasQuery $indicator) {
                        /** @var ReportQuery $reportQuery */
                        $reportQuery = $indicator->class();

                        return [
                            $indicator->getLabel() => Arr::wrap(
                                $reportQuery::aggregate($this->report),
                            ),
                        ];
                    }),
            ],
        ];
    }
}
