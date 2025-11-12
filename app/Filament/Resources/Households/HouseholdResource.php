<?php

declare(strict_types=1);

namespace App\Filament\Resources\Households;

use App\Filament\Resources\Households\Pages\ManageHouseholds;
use App\Filament\Resources\Households\Schemas\HouseholdForm;
use App\Filament\Resources\Households\Schemas\HouseholdInfolist;
use App\Filament\Resources\Households\Tables\HouseholdsTable;
use App\Models\Household;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class HouseholdResource extends Resource
{
    protected static ?string $model = Household::class;

    protected static bool $shouldRegisterNavigation = false;

    public static function getModelLabel(): string
    {
        return __('household.label.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('household.label.plural');
    }

    public static function form(Schema $schema): Schema
    {
        return HouseholdForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return HouseholdInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return HouseholdsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageHouseholds::route('/'),
        ];
    }
}
