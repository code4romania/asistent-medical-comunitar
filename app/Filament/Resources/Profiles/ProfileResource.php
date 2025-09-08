<?php

declare(strict_types=1);

namespace App\Filament\Resources\Profiles;

use App\Filament\Resources\Profiles\Pages\Onboard;
use App\Filament\Resources\Profiles\Pages\ViewGeneral;
use App\Filament\Resources\Profiles\Pages\EditGeneral;
use App\Filament\Resources\Profiles\Pages\ViewStudies;
use App\Filament\Resources\Profiles\Pages\EditStudies;
use App\Filament\Resources\Profiles\Pages\ViewEmployers;
use App\Filament\Resources\Profiles\Pages\EditEmployers;
use App\Filament\Resources\Profiles\Pages\ViewArea;
use App\Filament\Resources\Profiles\Pages\EditArea;
use App\Filament\Resources\ProfileResource\Pages;
use App\Filament\Resources\Profiles\RelationManagers\CoursesRelationManager;
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
            CoursesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'onboard' => Onboard::route('/onboard'),

            'general.view' => ViewGeneral::route('/general'),
            'general.edit' => EditGeneral::route('/general/edit'),

            'studies.view' => ViewStudies::route('/studies'),
            'studies.edit' => EditStudies::route('/studies/edit'),

            'employers.view' => ViewEmployers::route('/employers'),
            'employers.edit' => EditEmployers::route('/employers/edit'),

            'area.view' => ViewArea::route('/area'),
            'area.edit' => EditArea::route('/area/edit'),
        ];
    }
}
