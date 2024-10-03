<?php

declare(strict_types=1);

namespace App\Exports\Sheets;

use App\Models\Report;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithTitle;

class ReportCoverSheet implements FromCollection, WithTitle
{
    public Report $report;

    public function __construct(Report $report)
    {
        $this->report = $report;
    }

    public function title(): string
    {
        return 'Cover';
    }

    public function collection(): Collection
    {
        return collect([
            [__('report.column.category'), $this->report->category->label()],
            [__('report.column.type'), $this->report->type->label()],
            [__('report.column.period'), $this->report->period],
            [__('report.column.created_at'), $this->report->created_at->toFormattedDateTime()],
        ]);
    }
}
