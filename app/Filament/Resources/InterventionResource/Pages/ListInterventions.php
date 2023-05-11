<?php

declare(strict_types=1);

namespace App\Filament\Resources\InterventionResource\Pages;

use App\Contracts\Pages\WithSidebar;
use App\Filament\Actions\CreateCaseManagementAction;
use App\Filament\Actions\CreateIndividualServiceAction;
use App\Filament\Resources\BeneficiaryResource\Concerns;
use App\Filament\Resources\InterventionResource;
use App\Filament\Resources\InterventionResource\Concerns\HasRecordBreadcrumb;
use App\Models\Vulnerability\Vulnerability;
use App\Tables\Columns\InterventionsColumn;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Table;
use Filament\Tables\Columns\Layout;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;

class ListInterventions extends ListRecords implements WithSidebar
{
    use HasRecordBreadcrumb;
    use Concerns\HasActions;
    use Concerns\HasSidebar;
    use Concerns\InteractsWithBeneficiaryRecord;

    protected static string $resource = InterventionResource::class;

    protected function getTableQuery(): Builder
    {
        return Vulnerability::query()
            ->with('category')
            ->withInterventionsForBeneficiary($this->record);
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
            CreateIndividualServiceAction::make()
                ->record($this->getRecord()),
            CreateCaseManagementAction::make()
                ->record($this->getRecord()),
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
                Layout\Grid::make(4)
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