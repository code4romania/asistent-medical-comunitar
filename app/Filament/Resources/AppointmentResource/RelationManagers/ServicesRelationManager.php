<?php

declare(strict_types=1);

namespace App\Filament\Resources\AppointmentResource\RelationManagers;

use App\Enums\Intervention\Status;
use App\Filament\Resources\BeneficiaryResource;
use App\Models\Intervention;
use App\Tables\Columns\TextColumn;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\SelectColumn;
use Illuminate\Database\Eloquent\Builder;

class ServicesRelationManager extends RelationManager
{
    protected static string $relationship = 'interventions';

    protected static ?string $recordTitleAttribute = 'service_name';

    public static function getTitle(): string
    {
        return __('intervention.services');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('field.id'))
                    ->prefix('#')
                    ->size('sm')
                    ->sortable(),

                TextColumn::make('interventionable.service.name')
                    ->label(__('field.service_name'))
                    ->size('sm')
                    ->sortable(),

                TextColumn::make('vulnerability.name')
                    ->label(__('field.addressed_vulnerability'))
                    ->size('sm')
                    ->sortable(),

                SelectColumn::make('interventionable.status')
                    ->label(__('field.status'))
                    ->options(Status::options()),

            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\AssociateAction::make()
                    ->label(__('intervention.action.add_service'))
                    ->modalHeading(__('intervention.action.add_service'))
                    ->icon('heroicon-o-plus-circle')
                    ->color('primary')
                    ->recordTitle(
                        fn (Intervention $record) => sprintf('#%d - %s', $record->id, $record->service_name)
                    )
                    ->recordSelectSearchColumns([
                        'interventions.id',
                        'services.name',
                    ])
                    ->recordSelectOptionsQuery(function (Builder $query, self $livewire) {
                        $query
                            ->whereBeneficiary(
                                $livewire->getOwnerRecord()->beneficiary
                            )
                            ->leftJoin('interventionable_individual_services', 'interventions.interventionable_id', 'interventionable_individual_services.id')
                            ->leftJoin('services', 'services.id', 'interventionable_individual_services.service_id')
                            ->select([
                                'interventions.id',
                                'interventions.interventionable_type',
                                'interventions.interventionable_id',
                                'interventions.appointment_id',
                                'interventions.parent_id',
                                'services.name as service_name',
                            ]);
                    })
                    ->inverseRelationshipName('appointment')
                    ->preloadRecordSelect(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->url(fn (self $livewire, Intervention $record) => BeneficiaryResource::getUrl('interventions.view', [
                        'beneficiary' => $livewire->getOwnerRecord()->beneficiary,
                        'record' => $record,
                    ]))
                    ->iconButton(),

                Tables\Actions\DetachAction::make()
                    ->iconButton(),
            ])
            ->bulkActions([
                //
            ]);
    }
}
