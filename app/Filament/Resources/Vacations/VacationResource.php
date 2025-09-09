<?php

declare(strict_types=1);

namespace App\Filament\Resources\Vacations;

use App\Filament\Resources\Vacations\Pages\ManageVacations;
use App\Filament\Resources\Vacations\Schemas\VacationForm;
use App\Filament\Resources\Vacations\Schemas\VacationInfolist;
use App\Filament\Resources\Vacations\Tables\VacationsTable;
use App\Models\Vacation;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class VacationResource extends Resource
{
    protected static ?string $model = Vacation::class;

    protected static ?int $navigationSort = 6;

    protected static string | BackedEnum | null $navigationIcon = Heroicon::CalendarDateRange;

    public static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->isAdmin()
            || auth()->user()->isCoordinator();
    }

    public static function getModelLabel(): string
    {
        return __('vacation.label.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('vacation.label.plural');
    }

    public static function form(Schema $schema): Schema
    {
        return VacationForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return VacationInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return VacationsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageVacations::route('/'),
        ];
    }
}
