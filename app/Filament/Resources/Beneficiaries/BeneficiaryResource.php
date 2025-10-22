<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries;

use App\Filament\Resources\Beneficiaries\Pages\CreateBeneficiary;
use App\Filament\Resources\Beneficiaries\Pages\EditBeneficiary;
use App\Filament\Resources\Beneficiaries\Pages\ListActivities;
use App\Filament\Resources\Beneficiaries\Pages\ListBeneficiaries;
use App\Filament\Resources\Beneficiaries\Pages\ListDocuments;
use App\Filament\Resources\Beneficiaries\Pages\ListInterventions;
use App\Filament\Resources\Beneficiaries\Pages\ListOcasionalBeneficiaries;
use App\Filament\Resources\Beneficiaries\Pages\ListRegularBeneficiaries;
use App\Filament\Resources\Beneficiaries\Pages\ViewBeneficiary;
use App\Filament\Resources\Beneficiaries\Tables\BeneficiariesTable;
use App\Models\Beneficiary;
use BackedEnum;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class BeneficiaryResource extends Resource
{
    protected static ?string $model = Beneficiary::class;

    protected static ?int $navigationSort = 1;

    protected static string | BackedEnum | null $navigationIcon = Heroicon::UserGroup;

    protected static ?string $recordTitleAttribute = 'full_name';

    public static function getModelLabel(): string
    {
        return __('beneficiary.label.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('beneficiary.label.plural');
    }

    public static function getRecordTitle(?Model $record): string
    {
        return $record?->getAttribute(static::getRecordTitleAttribute()) ?? __('field.has_unknown_identity');
    }

    public static function table(Table $table): Table
    {
        return BeneficiariesTable::configure($table);
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
            'index' => ListBeneficiaries::route('/'),
            'regular' => ListRegularBeneficiaries::route('/regular'),
            'ocasional' => ListOcasionalBeneficiaries::route('/ocasional'),

            'create' => CreateBeneficiary::route('/create'),
            'view' => ViewBeneficiary::route('/{record}'),
            'edit' => EditBeneficiary::route('/{record}/edit'),

            'interventions' => ListInterventions::route('/{record}/interventions'),
            'documents' => ListDocuments::route('/{record}/documents'),
            'history' => ListActivities::route('/{record}/history'),
        ];
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        /** @var Beneficiary */
        $beneficiary = $page->getParentRecord() ?? $page->getRecord();

        if ($beneficiary->isOcasional()) {
            return [
                //
            ];
        }

        return $page->generateNavigationItems([
            ViewBeneficiary::class,
            ListInterventions::class,
            ListDocuments::class,
            ListActivities::class,
        ]);
    }
}
