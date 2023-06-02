<?php

declare(strict_types=1);

namespace App\Filament\Resources\AppointmentResource\RelationManagers;

use App\Enums\Intervention\Status;
use App\Filament\Resources\BeneficiaryResource;
use App\Models\Intervention\IndividualService;
use App\Models\Service\Service;
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
        return __('case.services');
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

                TextColumn::make('service.name')
                    ->label(__('field.service_name'))
                    ->size('sm')
                    ->sortable(),

                TextColumn::make('vulnerability.name')
                    ->label(__('field.addressed_vulnerability'))
                    ->size('sm')
                    ->sortable(),

                SelectColumn::make('status')
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
                    ->recordSelectOptionsQuery(function (Builder $query, self $livewire) {
                        $query
                            ->whereBeneficiary(
                                $livewire->getOwnerRecord()->beneficiary
                            )
                            ->addSelect([
                                'service_name' => Service::select('name')
                                    ->whereColumn('service_id', 'services.id'),
                            ]);
                    })
                    ->inverseRelationshipName('appointment')
                    ->preloadRecordSelect(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->url(fn (self $livewire, IndividualService $record) => BeneficiaryResource::getUrl('interventions.view', [
                        'record' => $livewire->getOwnerRecord()->beneficiary,
                        'intervention' => $record,
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
