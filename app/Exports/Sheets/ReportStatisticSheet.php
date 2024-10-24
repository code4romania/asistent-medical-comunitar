<?php

declare(strict_types=1);

namespace App\Exports\Sheets;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportStatisticSheet implements FromCollection, ShouldAutoSize, WithHeadings, WithTitle, WithStrictNullComparison, WithStyles
{
    public string $title;

    public Collection $columns;

    public Collection $data;

    public function __construct(array $table)
    {
        $this->title = data_get($table, 'title');

        $this->columns = collect(data_get($table, 'columns'));

        $this->data = collect(data_get($table, 'data'));
    }

    public function title(): string
    {
        return $this->title;
    }

    public function headings(): array
    {
        return $this->columns
            ->map(function (array $column) {
                $label = $column['label'];

                if (filled(data_get($column, 'suffix'))) {
                    $label .= "\n({$column['suffix']})";
                }

                return $label;
            })
            ->prepend('')
            ->all();
    }

    public function collection(): Collection
    {
        if ($this->columns->isEmpty()) {
            return $this->data->map(
                fn (array $row, string $label) => collect($row)
                    ->flatten()
                    ->prepend($label)
            );
        }

        return $this->data->map(
            fn (array $row, string $label) => $this->columns
                ->map(fn (array $column) => data_get($row, $column['name']))
                ->prepend($label)
        );
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'wrapText' => true,
                ],
            ],
            'A' => [
                'font' => [
                    'bold' => true,
                ],
                'alignment' => [
                    'wrapText' => true,
                ],
            ],
        ];
    }
}
