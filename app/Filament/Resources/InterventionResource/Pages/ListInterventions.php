<?php

declare(strict_types=1);

namespace App\Filament\Resources\InterventionResource\Pages;

use App\Concerns\InteractsWithBeneficiary;
use App\Contracts\Pages\WithSidebar;
use App\Filament\Resources\BeneficiaryResource\Concerns;
use App\Filament\Resources\InterventionResource;
use App\Filament\Resources\InterventionResource\Actions;
use App\Filament\Resources\InterventionResource\Concerns\HasRecordBreadcrumb;
use App\Filament\Tables\Columns\InterventionsColumn;
use App\Filament\Tables\Columns\TextColumn;
use App\Models\Vulnerability\Vulnerability;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Table;
use Filament\Tables\Columns\Layout;
use Illuminate\Database\Eloquent\Builder;

class ListInterventions extends ListRecords implements WithSidebar
{
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
            Actions\CreateIndividualServiceAction::make(),

            Actions\CreateCaseAction::make(),
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
