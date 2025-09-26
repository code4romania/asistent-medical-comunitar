<?php

declare(strict_types=1);

namespace App\Filament\Resources\Appointments\RelationManagers;

use App\Enums\Intervention\Status;
use App\Filament\Resources\Appointments\InterventionResource;
use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use App\Forms\Components\Select;
use App\Models\Appointment;
use App\Models\Intervention;
use Filament\Actions\AssociateAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;

class InterventionsRelationManager extends RelationManager
{
    protected static string $relationship = 'interventions';

    // protected static ?string $relatedResource = InterventionResource::class;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(200),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('service_name')
            ->inverseRelationship('appointment')
            ->modifyQueryUsing(fn (Builder $query) => $query->with(['vulnerability', 'parent']))
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
                    ->enum(Status::class)
                    ->selectablePlaceholder(false),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                AssociateAction::make()
                    ->label(__('intervention.action.add_service'))
                    ->modalHeading(__('intervention.action.add_service'))
                    ->icon('heroicon-o-plus-circle')
                    ->color('primary')
                    ->recordTitle(
                        fn (Intervention $record, Appointment $ownerRecord) => view('forms.components.appointment-intervention-item', [
                            'appointment' => $ownerRecord,
                            'intervention' => $record,
                        ])
                    )
                    ->recordSelect(
                        fn (Select $select) => $select
                            ->helperText(new HtmlString(__('appointment.service_already_associated')))
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
                    ->preloadRecordSelect(),
            ])
            ->recordActions([
                ViewAction::make()
                    // ->url(fn (self $livewire, Intervention $record) => BeneficiaryResource::getUrl('interventions.view', [
                    //     'beneficiary' => $livewire->getOwnerRecord()->beneficiary,
                    //     'record' => $record,
                    // ]))
                    ->iconButton(),

                DissociateAction::make()
                    ->modalHeading(__('intervention.action.dissociate_service'))
                    ->iconButton(),
            ])
            ->defaultSort('id', 'desc');
    }
}
