<?php

declare(strict_types=1);

namespace App\Exports;

use App\Enums\Report\Type;
use App\Exports\Sheets\ReportCoverSheet;
use App\Exports\Sheets\ReportListSheet;
use App\Exports\Sheets\ReportStatisticSheet;
use App\Models\Report;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ReportExport implements WithMultipleSheets
{
    public readonly Report $report;

    public function __construct(Report $report)
    {
        $this->report = $report;
    }

    public function sheets(): array
    {
        $sheet = match ($this->report->type) {
            Type::LIST => ReportListSheet::class,
            Type::STATISTIC => ReportStatisticSheet::class,
        };

        return $this->report->data
            ->map(fn (array $table) => new $sheet($table))
            ->prepend(new ReportCoverSheet($this->report))
            ->all();
    }
}
