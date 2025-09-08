<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use Filament\Actions\Action;
use App\Concerns\HasConditionalTableEmptyState;
use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use App\Filament\Resources\Interventions\InterventionResource;
use App\Models\Intervention;
use App\Tables\Columns\TextColumn;
use Closure;
use Filament\Tables\Concerns\CanPaginateRecords;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class OpenCasesWidget extends BaseWidget
{
    use HasConditionalTableEmptyState;
    use CanPaginateRecords {
        paginateTableQuery as protected;
    }

    protected static ?int $sort = 1;

    protected int | string | array $columnSpan = [
        'lg' => 2,
    ];

    public static function canView(): bool
    {
        return InterventionResource::canViewAny();
    }

    protected function getTableHeading(): string
    {
        return __('intervention.title.open_cases_widget');
    }

    protected function getTableQuery(): Builder
    {
        return Intervention::query()
            ->onlyCases()
            ->onlyOpen()
            ->withCount([
                'appointments' => fn (Builder $query) => $query->countUnique(),
                'interventions as realized_interventions_count' => fn (Builder $query) => $query->onlyRealized(),
            ]);
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
                ->size('sm'),

            TextColumn::make('realized_interventions_count')
                ->label(__('field.services_realized'))
                ->sortable(),

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
                ->label(__('intervention.action.view_case'))
                ->url($this->getTableRecordUrlUsing())
                ->size('sm')
                ->icon(null),
        ];
    }

    protected function getTableEmptyStateIcon(): ?string
    {
        return 'icon-empty-state';
    }

    protected function getTableEmptyStateHeading(): ?string
    {
        return __('intervention.empty.title');
    }
}
