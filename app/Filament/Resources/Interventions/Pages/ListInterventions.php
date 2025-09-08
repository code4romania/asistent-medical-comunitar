<?php

declare(strict_types=1);

namespace App\Filament\Resources\Interventions\Pages;

use App\Filament\Resources\Beneficiaries\Concerns\HasActions;
use App\Filament\Resources\Beneficiaries\Concerns\HasSidebar;
use App\Filament\Resources\Beneficiaries\Concerns\ListRecordsForBeneficiary;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Tables\Columns\Layout\Grid;
use Filament\Tables\Columns\Layout\Split;
use App\Concerns\HasConditionalTableEmptyState;
use App\Concerns\InteractsWithBeneficiary;
use App\Contracts\Pages\WithSidebar;
use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use App\Filament\Resources\BeneficiaryResource\Concerns;
use App\Filament\Resources\Interventions\InterventionResource;
use App\Filament\Resources\Interventions\Actions\CreateCaseAction;
use App\Filament\Resources\Interventions\Actions\CreateIndividualServiceAction;
use App\Filament\Resources\Interventions\Concerns\HasRecordBreadcrumb;
use App\Models\Vulnerability\Vulnerability;
use App\Tables\Columns\InterventionsColumn;
use App\Tables\Columns\TextColumn;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables;
use Filament\Tables\Columns\Layout;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ListInterventions extends ListRecords implements WithSidebar
{
    use HasConditionalTableEmptyState;
    use HasActions;
    use HasSidebar;
    use ListRecordsForBeneficiary;
    use InteractsWithBeneficiary;
    use HasRecordBreadcrumb {
        HasRecordBreadcrumb::getBreadcrumbs insteadof ListRecordsForBeneficiary;
    }

    protected static string $resource = InterventionResource::class;

    public function mount(...$args): void
    {
        parent::mount();

        [$beneficiary] = $args;

        $this->resolveBeneficiary($beneficiary);
    }

    protected function getTableQuery(): Builder
    {
        return Vulnerability::query()
            ->with('category')
            ->withInterventionsForBeneficiary($this->getBeneficiary());
    }

    public function getTitle(): string
    {
        return __('intervention.label.plural');
    }

    public function getBreadcrumb(): string
    {
        return $this->getTitle();
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateIndividualServiceAction::make(),

            CreateCaseAction::make(),
        ];
    }

    protected function getTableEmptyStateIcon(): ?string
    {
        if ($this->hasAlteredTableQuery()) {
            return null;
        }

        return 'icon-empty-state';
    }

    protected function getTableEmptyStateHeading(): ?string
    {
        if ($this->hasAlteredTableQuery()) {
            return null;
        }

        if ($this->getBeneficiary()->hasCatagraphy()) {
            return __('intervention.empty.title');
        }

        return __('catagraphy.vulnerability.empty.title');
    }

    protected function getTableEmptyStateDescription(): ?string
    {
        if ($this->hasAlteredTableQuery()) {
            return null;
        }

        if ($this->getBeneficiary()->hasCatagraphy()) {
            return null;
        }

        return __('intervention.empty_active.description');
    }

    protected function getTableEmptyStateActions(): array
    {
        return [

            Action::make('create')
                ->label(__('catagraphy.vulnerability.empty.create'))
                ->url(BeneficiaryResource::getUrl('catagraphy.edit', ['record' => $this->getBeneficiary()]))
                ->button()
                ->color('gray')
                ->hidden(fn () => $this->getBeneficiary()->hasCatagraphy()),

            CreateAction::make('create_individual_service')
                ->label(__('intervention.action.add_service'))
                ->modalHeading(__('intervention.action.add_service'))
                ->using(fn (array $data, $livewire) => CreateIndividualServiceAction::create($data, $livewire))
                ->schema(InterventionResource::getIndividualServiceFormSchema())
                ->icon('heroicon-o-plus-circle')
                ->button()
                ->color('gray')
                ->hidden(fn () => ! $this->getBeneficiary()->hasCatagraphy() || $this->hasAlteredTableQuery()),

            CreateAction::make('create_case')
                ->label(__('intervention.action.open_case'))
                ->modalHeading(__('intervention.action.open_case'))
                ->using(fn (array $data, $livewire) => CreateCaseAction::create($data, $livewire))
                ->schema(InterventionResource::getCaseFormSchema())
                ->icon('heroicon-o-folder-plus')
                ->button()
                ->color('gray')
                ->hidden(fn () => ! $this->getBeneficiary()->hasCatagraphy() || $this->hasAlteredTableQuery()),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Grid::make(5)
                    ->schema([
                        TextColumn::make('name')
                            ->columnSpan(2)
                            ->label(__('field.vulnerability'))
                            ->description(fn ($record) => $record->category?->name, position: 'above')
                            ->alignment('left')
                            ->searchable()
                            ->extraAttributes(fn (Vulnerability $record) => [
                                'class' => 'px-2 py-3 ' . ($record->id === 'NONE' ? 'italic' : null),
                            ]),

                        TextColumn::make('interventions_count')
                            ->alignment('left')
                            ->description(__('field.interventions'), position: 'above')
                            ->label(__('field.interventions'))
                            ->extraAttributes([
                                'class' => 'px-2 py-3',
                            ]),

                        TextColumn::make('services_count')
                            ->description(__('field.services_realized'), position: 'above')
                            ->label(__('field.services_realized'))
                            ->formatStateUsing(fn (Vulnerability $record) => \sprintf(
                                '%s/%s',
                                $record->interventions->sum('realized_services_count'),
                                $record->interventions->sum('all_services_count')
                            ))
                            ->alignment('left')
                            ->extraAttributes([
                                'class' => 'px-2 py-3',
                            ]),

                        TextColumn::make('appointments_count')
                            ->description(__('field.associated_appointments'), position: 'above')
                            ->label(__('field.associated_appointments'))
                            ->alignment('left')
                            ->extraAttributes([
                                'class' => 'px-2 py-3',
                            ]),
                    ]),

                Split::make([
                    InterventionsColumn::make('interventions'),
                ])->collapsible(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                //
            ])
            ->toolbarActions([
                //
            ]);
    }
}
