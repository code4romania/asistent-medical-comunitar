<?php

declare(strict_types=1);

namespace App\Exports;

use App\Models\Feedback;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class FeedbackExport implements FromQuery, ShouldAutoSize, WithHeadings, WithMapping
{
    use Exportable;

    public function query(): Builder
    {
        return Feedback::query()
            ->with([
                'category',
                'subcategory',
                'county',
                'city',
                'user:id,full_name,role',
            ])
            ->latest('id');
    }

    public function headings(): array
    {
        return [
            __('field.id'),
            __('field.county'),
            __('field.city'),
            __('field.user'),
            __('field.role'),
            __('field.date'),
            __('field.category'),
            __('field.subcategory'),
            __('field.notes'),
        ];
    }

    /**
     * @param Feedback $row
     */
    public function map($row): array
    {
        return [
            $row->id,
            $row->county->name,
            $row->city->name,
            $row->user->full_name,
            $row->user->role?->getLabel(),
            $row->created_at->toDateString(),
            $row->category->name,
            $row->subcategory?->name,
            $row->description,
        ];
    }
}
