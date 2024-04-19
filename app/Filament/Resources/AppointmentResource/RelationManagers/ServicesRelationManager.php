<?php

declare(strict_types=1);

namespace App\Filament\Resources\AppointmentResource\RelationManagers;

use App\Enums\Intervention\Status;
use App\Filament\Resources\BeneficiaryResource;
use App\Filament\Tables\Columns\TextColumn;
use App\Models\Appointment;
use App\Models\Intervention;
use Filament\Forms;
use Filament\Forms\Components\Select;
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
                    ->maxLength(200),
            ]);
    }

    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()
            ->with(['vulnerability', 'parent']);
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

                TextColumn::make('vulnerability_label')
                    ->label(__('field.addressed_vulnerability'))
                    ->size('sm')
                    ->formatStateUsing(
                        fn (Intervention $record, ?string $state) => $state ?? $record->parent->vulnerability_label
                    )
                    ->sortable(),

                SelectColumn::make('interventionable.status')
                    ->label(__('field.status'))
                    ->options(Status::options())
                    ->disablePlaceholderSelection(),
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
                        fn (Intervention $record, Appointment $ownerRecord) => view('components.forms.appointment-intervention-item', [
                            'appointment' => $ownerRecord,
                            'intervention' => $record,
                        ])
                    )
                    ->recordSelect(
                        fn (Select $select) => $select
                            ->helperText(__('appointment.service_already_associated'))
                            ->allowHtml()
                    )
                    ->recordSelectSearchColumns([
                        'interventions.id',
                        'services.name',
                    ])
                    ->recordSelectOptionsQuery(function (Builder $query, self $livewire) {
                        $query
                            ->whereBeneficiary($livewire->getOwnerRecord()->beneficiary)
                            ->onlyPlanned()
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

                Tables\Actions\DissociateAction::make()
                    ->modalHeading(__('intervention.action.dissociate_service'))
                    ->inverseRelationshipName('appointment')
                    ->iconButton(),
            ])
            ->bulkActions([
                //
            ]);
    }
}
