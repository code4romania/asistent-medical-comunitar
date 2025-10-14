<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Widgets;

use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use App\Filament\Resources\Beneficiaries\Resources\Interventions\InterventionResource;
use App\Models\Beneficiary;
use App\Models\Intervention;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;

class ActiveInterventionsWidget extends TableWidget
{
    public Beneficiary $record;

    protected int | string | array $columnSpan = [
        'default' => 'full',
        '2xl' => 2,
    ];

    public function table(Table $table): Table
    {
        return $table
            ->query(function (): Builder {
                return Intervention::query()
                    ->with('vulnerability')
                    ->whereBeneficiary($this->record)
                    ->whereRoot()
                    ->onlyOpen();
            })
            ->heading(__('beneficiary.section.active_interventions'))
            ->columns([
                TextColumn::make('id')
                    ->label(__('field.id'))
                    ->prefix('#')
                    ->sortable(),

                TextColumn::make('name')
                    ->label(__('field.intervention_name')),

                TextColumn::make('vulnerability_label')
                    ->label(__('field.vulnerability'))
                    ->sortable(),

                TextColumn::make('appointment_count')
                    ->counts('appointment')
                    ->label(__('field.appointments'))
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                ViewAction::make()
                    ->label(__('beneficiary.action.view_details'))
                    ->url(BeneficiaryResource::getUrl('interventions', ['record' => $this->record]))
                    ->icon(null)
                    ->button()
                    ->color('gray'),
            ])
            ->recordActions([
                ViewAction::make()
                    ->iconButton(),
            ])
            ->recordUrl(
                fn (Intervention $record): string => InterventionResource::getUrl('view', [
                    'beneficiary' => $record->beneficiary_id,
                    'record' => $record,
                ]),
            )
            ->paginated([5]);
    }
}
