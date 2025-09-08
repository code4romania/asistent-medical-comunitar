<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users;

use App\Filament\Resources\Users\Pages\ListNurses;
use App\Filament\Resources\Users\Pages\ListCoordinators;
use App\Filament\Resources\Users\Pages\ListAdmins;
use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\ViewUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\Nurse\ViewGeneral;
use App\Filament\Resources\Users\Pages\Nurse\EditGeneral;
use App\Filament\Resources\Users\Pages\Nurse\ViewStudies;
use App\Filament\Resources\Users\Pages\Nurse\EditStudies;
use App\Filament\Resources\Users\Pages\Nurse\ViewEmployers;
use App\Filament\Resources\Users\Pages\Nurse\EditEmployers;
use App\Filament\Resources\Users\Pages\Nurse\ViewArea;
use App\Filament\Resources\Users\Pages\Nurse\EditArea;
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
            'index' => ListNurses::route('/'),
            'coordinators' => ListCoordinators::route('/coordinators'),
            'admins' => ListAdmins::route('/admins'),

            'create' => CreateUser::route('/create'),
            'view' => ViewUser::route('/{record}'),
            'edit' => EditUser::route('/{record}/edit'),

            'general.view' => ViewGeneral::route('/{record}/general'),
            'general.edit' => EditGeneral::route('/{record}/general/edit'),

            'studies.view' => ViewStudies::route('/{record}/studies'),
            'studies.edit' => EditStudies::route('/{record}/studies/edit'),

            'employers.view' => ViewEmployers::route('/{record}/employers'),
            'employers.edit' => EditEmployers::route('/{record}/employers/edit'),

            'area.view' => ViewArea::route('/{record}/area'),
            'area.edit' => EditArea::route('/{record}/area/edit'),
        ];
    }
}
