<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\HouseholdResource\Pages\CreateHousehold;
use App\Filament\Resources\HouseholdResource\Pages\EditHousehold;
use App\Filament\Resources\HouseholdResource\Pages\ListHouseholds;
use App\Models\Household;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\Layout\View;
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
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('field.household'))
                    ->sortable(),
                TextColumn::make('families_count')
                    ->label(__('field.families'))
                    ->counts('families')
                    ->sortable(),
                TextColumn::make('beneficiaries_count')
                    ->label(__('field.beneficiaries'))
                    ->counts('beneficiaries')
                    ->sortable(),

                // View::make("users.table.collapsible-row-content"),
                // ->collapsible(),

            ])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
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
            'index' => ListHouseholds::route('/'),
            'create' => CreateHousehold::route('/create'),
            'edit' => EditHousehold::route('/{record}/edit'),
        ];
    }
}
