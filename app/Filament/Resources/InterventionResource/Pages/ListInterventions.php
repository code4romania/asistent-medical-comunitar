<?php

declare(strict_types=1);

namespace App\Filament\Resources\InterventionResource\Pages;

use App\Concerns\HasConditionalTableEmptyState;
use App\Concerns\InteractsWithBeneficiary;
use App\Contracts\Pages\WithSidebar;
use App\Filament\Resources\BeneficiaryResource;
use App\Filament\Resources\BeneficiaryResource\Concerns;
use App\Filament\Resources\InterventionResource;
use App\Filament\Resources\InterventionResource\Actions\CreateCaseAction;
use App\Filament\Resources\InterventionResource\Actions\CreateIndividualServiceAction;
use App\Filament\Resources\InterventionResource\Concerns\HasRecordBreadcrumb;
use App\Filament\Tables\Columns\InterventionsColumn;
use App\Filament\Tables\Columns\TextColumn;
use App\Models\Vulnerability\Vulnerability;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\Layout;
use Illuminate\Database\Eloquent\Builder;

class ListInterventions extends ListRecords implements WithSidebar
{
    use HasConditionalTableEmptyState;
    use HasRecordBreadcrumb;
    use Concerns\HasActions;
    use Concerns\HasSidebar;
    use Concerns\ListRecordsForBeneficiary;
    use InteractsWithBeneficiary;

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

    protected function getActions(): array
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

        return __('intervention.empty.description');
    }

    protected function getTableEmptyStateActions(): array
    {
        return [

            Tables\Actions\Action::make('create')
                ->label(__('catagraphy.vulnerability.empty.create'))
                ->url(BeneficiaryResource::getUrl('catagraphy.edit', ['record' => $this->getBeneficiary()]))
                ->button()
                ->color('secondary')
                ->hidden(fn () => $this->getBeneficiary()->hasCatagraphy()),

            Tables\Actions\CreateAction::make('create_individual_service')
                ->label(__('intervention.action.add_service'))
                ->modalHeading(__('intervention.action.add_service'))
                ->using(fn (array $data, $livewire) => CreateIndividualServiceAction::create($data, $livewire))
                ->form(InterventionResource::getIndividualServiceFormSchema())
                ->icon('heroicon-o-plus-circle')
                ->button()
                ->color('secondary')
                ->hidden(fn () => $this->hasAlteredTableQuery()),

            Tables\Actions\CreateAction::make('create_case')
                ->label(__('intervention.action.open_case'))
                ->modalHeading(__('intervention.action.open_case'))
                ->using(fn (array $data, $livewire) => CreateCaseAction::create($data, $livewire))
                ->form(InterventionResource::getCaseFormSchema())
                ->icon('heroicon-o-folder-add')
                ->button()
                ->color('secondary')
                ->hidden(fn () => $this->hasAlteredTableQuery()),
        ];
    }

    protected function table(Table $table): Table
    {
        return $table
            ->columns([
                Layout\Grid::make(5)
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
                            ->formatStateUsing(fn (Vulnerability $record) => sprintf(
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

                Layout\Split::make([
                    InterventionsColumn::make('interventions'),
                ])->collapsible(),
            ])
            ->filters([
                //
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                //
            ]);
    }
}
