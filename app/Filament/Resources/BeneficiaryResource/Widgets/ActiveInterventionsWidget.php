<?php

declare(strict_types=1);

namespace App\Filament\Resources\BeneficiaryResource\Widgets;

use App\Filament\Resources\BeneficiaryResource;
use App\Filament\Tables\Columns\TextColumn;
use App\Models\Beneficiary;
use App\Models\Intervention;
use Closure;
use Filament\Tables\Actions\Action;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class ActiveInterventionsWidget extends BaseWidget
{
    public ?Beneficiary $record = null;

    protected int | string | array $columnSpan = [
        'default' => 'full',
        'xl' => 2,
    ];

    protected $listeners = [
        'updateInterventionsWidget' => '$refresh',
    ];

    protected function getTableHeading(): string
    {
        return __('beneficiary.section.active_interventions');
    }

    protected function getTableHeaderActions(): array
    {
        return [
            Action::make('view')
                ->label(__('beneficiary.action.view_details'))
                ->url(BeneficiaryResource::getUrl('interventions.index', ['beneficiary' => $this->record]))
                ->button()
                ->color('secondary'),
        ];
    }

    protected function getTableQuery(): Builder
    {
        return Intervention::query()
            ->where('beneficiary_id', $this->record->id)
            ->onlyOpen();
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('id')
                ->label(__('field.id'))
                ->prefix('#')
                ->size('sm')
                ->sortable(),

            TextColumn::make('name')
                ->label(__('field.intervention_name'))
                ->size('sm'),

            TextColumn::make('vulnerability.name')
                ->label(__('field.vulnerability'))
                ->size('sm')
                ->sortable(),

            TextColumn::make('appointment_count')
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
                ->label(__('intervention.action.view_case'))
                ->url($this->getTableRecordUrlUsing())
                ->size('sm')
                ->icon('heroicon-o-eye')
                ->iconButton(),
        ];
    }

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [5];
    }

    protected function getTableEmptyStateIcon(): ?string
    {
        return 'icon-empty-state';
    }

    protected function getTableEmptyStateHeading(): ?string
    {
        return __('intervention.empty_active.title');
    }

    protected function getTableEmptyStateDescription(): ?string
    {
        return ! $this->record->hasCatagraphy()
            ? __('intervention.empty_active.description')
            : null;
    }

    protected function getTableEmptyStateActions(): array
    {
        return [
            Action::make('create_catagraphy')
                ->label(__('catagraphy.vulnerability.empty.create'))
                ->url(BeneficiaryResource::getUrl('catagraphy.edit', ['record' => $this->record]))
                ->button()
                ->color('secondary')
                ->visible(fn () => ! $this->record->hasCatagraphy()),

            Action::make('create_intervention')
                ->label(fn () => __('intervention.empty_active.create'))
                ->url(BeneficiaryResource::getUrl('interventions.index', ['beneficiary' => $this->record]))
                ->button()
                ->color('secondary')
                ->visible(fn () => $this->record->hasCatagraphy()),
        ];
    }

    protected function getDefaultTableSortColumn(): ?string
    {
        return 'id';
    }

    protected function getDefaultTableSortDirection(): ?string
    {
        return 'desc';
    }
}
