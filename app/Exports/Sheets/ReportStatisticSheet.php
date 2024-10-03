<?php

declare(strict_types=1);

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\WithTitle;

class ReportStatisticSheet implements WithTitle
{
    public array $table;

    public function __construct(array $table)
    {
        $this->table = $table;
    }

    public function title(): string
    {
        return data_get($this->table, 'title');
    }
}
