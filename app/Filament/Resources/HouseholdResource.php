<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\HouseholdResource\Pages\ManageHouseholds;
use App\Models\Household;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

class HouseholdResource extends Resource
{
    protected static ?string $model = Household::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label(__('field.household_name')),

                Repeater::make('families')
                    ->relationship()
                    ->minItems(1)
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('name')
                            ->label(__('field.family_name')),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('field.household'))
                    ->sortable()
                    ->searchable()
                    ->alignment('left'),
                TextColumn::make('families_count')
                    ->label(__('field.families_count'))
                    ->counts('families')
                    ->sortable(),
                TextColumn::make('beneficiaries_count')
                    ->label(__('field.beneficiaries_count'))
                    ->counts('beneficiaries')
                    ->sortable(),


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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageHouseholds::route('/'),
        ];
    }
}
