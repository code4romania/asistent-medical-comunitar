<?php

declare(strict_types=1);

namespace App\Reports;

use App\Models\Report;
use Illuminate\Support\Collection;

abstract class ReportData
{
    public Report $report;

    public array $header = [];

    public array $rows = [];

    abstract public function getName(): string;

    abstract public function getData(): Collection;

    abstract public function query(string $forIndicator);

    public function getTitle(): string
    {
        $title = [
            $this->getName(),
        ];

        if ($this->report->date_until === null) {
            $title[] = __('report.title.date', [
                'date' => $this->report->date_from->toFormattedDate(),
            ]);
        } else {
            $title[] = __('report.title.date_range', [
                'from' => $this->report->date_from->toFormattedDate(),
                'to' => $this->report->date_until->toFormattedDate(),
            ]);
        }

        return implode(' ', $title);
    }
}
