<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\ProfileResource\Pages;
use App\Filament\Resources\ProfileResourcesResource\RelationManagers\CoursesRelationManager;
use App\Models\User;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Model;

class ProfileResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $slug = 'profile';

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static bool $shouldRegisterNavigation = false;
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            CoursesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProfile::route('/'),

            'general.view' => Pages\ViewGeneral::route('/general'),
            'general.edit' => Pages\EditGeneral::route('/general/edit'),

            'studies.view' => Pages\ViewStudies::route('/studies'),
            'studies.edit' => Pages\EditStudies::route('/studies/edit'),

            'employers.view' => Pages\ViewEmployers::route('/employers'),
            'employers.edit' => Pages\EditEmployers::route('/employers/edit'),

            'area.view' => Pages\ViewArea::route('/area'),
            'area.edit' => Pages\EditArea::route('/area/edit'),
        ];
    }
}
