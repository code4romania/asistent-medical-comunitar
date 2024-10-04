<?php

declare(strict_types=1);

namespace App\Jobs\GenerateReport\Standard;

use App\Contracts\Enums\HasQuery;
use App\Jobs\GenerateReport\GenerateStandardReportJob;
use App\Reports\Queries\ReportQuery;
use BackedEnum;
use Illuminate\Database\Eloquent\Model;

class GenerateListJob extends GenerateStandardReportJob
{
    public function generate(): void
    {
        $this->report->data = $this->report->indicators()
            ->map(function (HasQuery $indicator) {
                /** @var ReportQuery $reportQuery */
                $reportQuery = $indicator->class();

                $columns = collect($reportQuery::columns());

                return [
                    'title' => $indicator->label(),
                    'columns' => $columns
                        ->map(fn (string $label, string $name) => [
                            'name' => $name,
                            'label' => $label,
                        ])
                        ->values(),
                    'data' => $reportQuery::build($this->report)
                        ->get()
                        ->map(
                            fn (Model $record) => $columns
                                ->map(function (string $label, string $name) use ($record) {
                                    $value = $record->{$name};

                                    if ($name === 'date_of_birth') {
                                        $value = $record->age;
                                    }

                                    if ($value instanceof BackedEnum) {
                                        $value = $value->label();
                                    }

                                    return $value;
                                })

                                ->put('actions', $reportQuery::getRecordActions([
                                    'record' => $record,
                                ]))
                        ),
                ];
            });
    }
}
