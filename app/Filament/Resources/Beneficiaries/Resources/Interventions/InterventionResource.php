<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Resources\Interventions;

use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use App\Filament\Resources\Beneficiaries\Resources\Interventions\Pages\CreateIntervention;
use App\Filament\Resources\Beneficiaries\Resources\Interventions\Pages\EditIntervention;
use App\Filament\Resources\Beneficiaries\Resources\Interventions\Pages\ViewIntervention;
use App\Filament\Resources\Beneficiaries\Resources\Interventions\Schemas\InterventionForm;
use App\Filament\Resources\Beneficiaries\Resources\Interventions\Schemas\InterventionInfolist;
use App\Filament\Resources\Beneficiaries\Resources\Interventions\Tables\InterventionsTable;
use App\Models\Intervention;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class InterventionResource extends Resource
{
    protected static ?string $model = Intervention::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $parentResource = BeneficiaryResource::class;

    public static function form(Schema $schema): Schema
    {
        return InterventionForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return InterventionInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InterventionsTable::configure($table);
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
            'create' => CreateIntervention::route('/create'),
            'view' => ViewIntervention::route('/{record}'),
            'edit' => EditIntervention::route('/{record}/edit'),
        ];
    }
}
