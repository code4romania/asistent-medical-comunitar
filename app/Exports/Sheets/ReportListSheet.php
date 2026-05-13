<?php

declare(strict_types=1);

namespace App\Exports\Sheets;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportListSheet implements FromCollection, ShouldAutoSize, WithColumnFormatting, WithHeadings, WithTitle, WithStrictNullComparison, WithStyles
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
        return [
            [$this->title],
            [], // empty row
            $this->columns->pluck('label')->all(),
        ];
    }

    public function collection(): Collection
    {
        return $this->data->map(
            fn (array $row) => $this->columns
                ->map(fn (array $column) => data_get($row, $column['name']) ?? '–')
        );
    }

    public function styles(Worksheet $sheet)
    {
        $lastCol = Coordinate::stringFromColumnIndex($this->columns->count());
        $sheet->mergeCells("A1:{$lastCol}1");

        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 14,
                ],
            ],
            3 => [
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

    public function columnFormats(): array
    {
        return $this->columns
            ->mapWithKeys(fn (array $column, int $index): array => [
                Coordinate::stringFromColumnIndex($index + 1) => match ($column['name']) {
                    'cnp' => NumberFormat::FORMAT_NUMBER,
                    default => null,
                },
            ])
            ->reject(fn (?string $format) => blank($format))
            ->all();
    }
}
