<?php

declare(strict_types=1);

namespace App\Jobs\GenerateReport\Standard\Nurse;

use App\Contracts\Enums\HasQuery;
use App\Jobs\GenerateReport\Standard\GenerateStandardReportJob;
use App\Reports\Queries\ReportQuery;
use BackedEnum;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class GenerateListReportJob extends GenerateStandardReportJob
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
                        ->distinct('id')
                        ->get()
                        ->map(
                            fn (Model $record) => $columns
                                ->map(fn (string $label, string $name) => $this->normalizeValue($name, $record))
                                ->put('actions', $reportQuery::getRecordActions($record))
                        ),
                ];
            })
            ->values();
    }

    protected function normalizeValue(string $name, Model $record): mixed
    {
        $value = $record->{$name};

        if ($name === 'date_of_birth') {
            $value = $record->age;
        }

        if ($value instanceof BackedEnum) {
            $value = $value->label();
        }

        if ($value instanceof Carbon) {
            $value = $value->toFormattedDate();
        }

        if (\is_bool($value)) {
            $value = match ($value) {
                true => __('forms::components.select.boolean.true'),
                false => __('forms::components.select.boolean.false'),
            };
        }

        return $value;
    }
}
