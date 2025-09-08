<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Widgets;

use Filament\Actions\Action;
use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use App\Models\Beneficiary;
use App\Models\Intervention;
use App\Tables\Columns\TextColumn;
use Closure;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class ActiveInterventionsWidget extends BaseWidget
{
    public ?Beneficiary $record = null;

    protected int | string | array $columnSpan = [
        'default' => 'full',
        '2xl' => 2,
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
                ->color('gray'),
        ];
    }

    protected function getTableQuery(): Builder
    {
        return Intervention::query()
            ->with('vulnerability')
            ->whereBeneficiary($this->record)
            ->whereRoot()
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

            TextColumn::make('vulnerability_label')
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
                ->color('gray')
                ->visible(fn () => ! $this->record->hasCatagraphy()),

            Action::make('create_intervention')
                ->label(fn () => __('intervention.empty_active.create'))
                ->url(BeneficiaryResource::getUrl('interventions.index', ['beneficiary' => $this->record]))
                ->button()
                ->color('gray')
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
