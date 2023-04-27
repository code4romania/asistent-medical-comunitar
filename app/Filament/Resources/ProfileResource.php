<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\ProfileResource\Pages;
use App\Filament\Resources\ProfileResource\RelationManagers\CoursesRelationManager;
use App\Models\User;
use Filament\Resources\Resource;

class ProfileResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $slug = 'profile';

    protected static bool $shouldRegisterNavigation = false;

    public static function getRelations(): array
    {
        return [
            CoursesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
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
