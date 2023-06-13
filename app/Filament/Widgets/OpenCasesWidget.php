<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Filament\Resources\BeneficiaryResource;
use App\Models\Intervention;
use App\Models\Intervention\InterventionableCase;
use App\Tables\Columns\TextColumn;
use Closure;
use Filament\Tables\Actions\Action;
use Filament\Tables\Concerns\CanPaginateRecords;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class OpenCasesWidget extends BaseWidget
{
    use CanPaginateRecords {
        paginateTableQuery as protected;
    }

    protected static ?int $sort = 1;

    protected int | string | array $columnSpan = [
        'lg' => 2,
    ];

    protected function getTableQuery(): Builder
    {
        return Intervention::query()
            ->whereHasMorph(
                'interventionable',
                InterventionableCase::class,
                fn (Builder $query) => $query->onlyOpen()
            );
    }

    protected function getTableQueryStringIdentifier(): ?string
    {
        return 'cases';
    }

    protected function getDefaultTableSortColumn(): ?string
    {
        return 'id';
    }

    protected function getDefaultTableSortDirection(): ?string
    {
        return 'desc';
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('id')
                ->label(__('field.id'))
                ->prefix('#')
                ->size('sm')
                ->sortable(),

            TextColumn::make('beneficiary.full_name')
                ->label(__('field.beneficiary'))
                ->size('sm')
                ->sortable(),

            TextColumn::make('name')
                ->label(__('field.intervention_name'))
                ->size('sm')
                ->sortable(),

            TextColumn::make('realized_interventions_count')
                ->label(__('field.services_realized')),

            TextColumn::make('appointments_count')
                ->counts('appointment')
                ->label(__('field.appointments'))
                ->sortable(),
        ];
    }

    protected function getTableRecordUrlUsing(): ?Closure
    {
        return fn (Intervention $record) => BeneficiaryResource::getUrl('interventions.view', [
            'beneficiary' => $record->beneficiary_id,
            'record' => $record,
        ]);
    }

    protected function getTableActions(): array
    {
        return [
            Action::make('view')
                ->url($this->getTableRecordUrlUsing())
                ->size('sm')
                ->icon(null),
        ];
    }
}
