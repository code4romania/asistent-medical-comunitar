<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\HouseholdResource\Pages\ManageHouseholds;
use App\Models\Beneficiary;
use App\Models\Family;
use App\Models\Household;
use App\Tables\Columns\HouseholdFamiliesColumn;
use App\Tables\Columns\TextColumn;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\Layout\Grid;
use Filament\Tables\Columns\Layout\Split;
use Illuminate\Database\Eloquent\Builder;

class HouseholdResource extends Resource
{
    protected static ?string $model = Household::class;

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        $beneficiaries = Beneficiary::pluck('full_name', 'id');

        return $form
            ->schema([
                TextInput::make('name')
                    ->label(__('field.household_name')),

                Repeater::make('families')
                    ->relationship(callback: function (Builder $query) {
                        $query->with('beneficiaries');
                    })
                    ->minItems(1)
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('name')
                            ->label(__('field.family_name')),

                        Select::make('beneficiaries')
                            ->options($beneficiaries)
                            ->searchable()
                            ->multiple()
                            ->loadStateFromRelationshipsUsing(static function ($component, $state) {
                                $component->state(
                                    $component->getModelInstance()
                                        ->beneficiaries
                                        ->pluck('id')
                                        ->all()
                                );
                            })
                            ->saveRelationshipsUsing(function (Family $record, $state) {
                                $record->beneficiaries()
                                    ->whereNotIn('id', $state)
                                    ->update([
                                        'family_id' => null,
                                    ]);

                                Beneficiary::query()
                                    ->whereIn('id', $state)
                                    ->update([
                                        'family_id' => $record->id,
                                    ]);
                            }),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Grid::make(3)
                    ->schema([
                        TextColumn::make('name')
                            ->label(__('field.household'))
                            ->description(__('field.household'), position: 'above')
                            ->searchable()
                            ->sortable()
                            ->alignment('left'),

                        TextColumn::make('families_count')
                            ->label(__('field.families_count'))
                            ->description(__('field.families_count'), position: 'above')
                            ->alignment('left')
                            ->counts('families')
                            ->sortable(),

                        TextColumn::make('beneficiaries_count')
                            ->label(__('field.beneficiaries_count'))
                            ->description(__('field.beneficiaries_count'), position: 'above')
                            ->alignment('left')
                            ->counts('beneficiaries')
                            ->sortable(),
                    ]),

                Split::make([
                    HouseholdFamiliesColumn::make('families'),
                ])->collapsible(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->iconButton(),
                Tables\Actions\EditAction::make()
                    ->iconButton(),
                Tables\Actions\DeleteAction::make()
                    ->iconButton(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageHouseholds::route('/'),
        ];
    }
}
