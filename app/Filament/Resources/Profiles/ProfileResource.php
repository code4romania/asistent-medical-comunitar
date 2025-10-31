<?php

declare(strict_types=1);

namespace App\Filament\Resources\Profiles;

use App\Models\User;
use Filament\Resources\Resource;

class ProfileResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $slug = 'profile';

    protected static bool $shouldRegisterNavigation = false;

    protected static bool $shouldSkipAuthorization = true;

    public static function getRelations(): array
    {
        return [
            RelationManagers\CoursesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\Redirect::route('/'),
            'onboard' => Pages\Onboard::route('/onboard'),

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
