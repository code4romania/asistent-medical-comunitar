<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users;

use App\Filament\Resources\Users\Schemas\UserForm;
use App\Filament\Resources\Users\Schemas\UserInfolist;
use App\Models\User;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'full_name';

    public static function getModelLabel(): string
    {
        return __('user.label.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('user.label.plural');
    }

    public static function form(Schema $schema): Schema
    {
        return UserForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return UserInfolist::configure($schema);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListNurses::route('/'),
            'coordinators' => Pages\ListCoordinators::route('/coordinators'),
            'admins' => Pages\ListAdmins::route('/admins'),

            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),

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
