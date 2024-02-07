<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Resources\Resource;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?int $navigationSort = 1;

    public static function getModelLabel(): string
    {
        return __('user.label.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('user.label.plural');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNurses::route('/'),
            'coordinators' => Pages\ListCoordinators::route('/coordinators'),
            'admins' => Pages\ListAdmins::route('/admins'),

            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}/view'),

            'general.view' => Pages\Nurse\ViewGeneral::route('/{record}/general'),
            'general.edit' => Pages\Nurse\EditGeneral::route('/{record}/general/edit'),

            'studies.view' => Pages\Nurse\ViewStudies::route('/{record}/studies'),
            'studies.edit' => Pages\Nurse\EditStudies::route('/{record}/studies/edit'),

            'employers.view' => Pages\Nurse\ViewEmployers::route('/{record}/employers'),
            'employers.edit' => Pages\Nurse\EditEmployers::route('/{record}/employers/edit'),

            'area.view' => Pages\Nurse\ViewArea::route('/{record}/area'),
            'area.edit' => Pages\Nurse\EditArea::route('/{record}/area/edit'),
        ];
    }
}
