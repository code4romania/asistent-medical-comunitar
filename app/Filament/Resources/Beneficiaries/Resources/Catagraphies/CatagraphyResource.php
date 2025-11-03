<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Resources\Catagraphies;

use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use App\Filament\Resources\Beneficiaries\Resources\Catagraphies\Pages\EditCatagraphy;
use App\Filament\Resources\Beneficiaries\Resources\Catagraphies\Pages\SummaryCatagraphy;
use App\Filament\Resources\Beneficiaries\Resources\Catagraphies\Pages\ViewCatagraphy;
use App\Filament\Resources\Beneficiaries\Resources\Catagraphies\Schemas\CatagraphyForm;
use App\Filament\Resources\Beneficiaries\Resources\Catagraphies\Schemas\CatagraphyInfolist;
use App\Models\Catagraphy;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;

class CatagraphyResource extends Resource
{
    protected static ?string $model = Catagraphy::class;

    protected static ?string $parentResource = BeneficiaryResource::class;

    protected static ?string $slug = 'catagraphy';

    public static function form(Schema $schema): Schema
    {
        return CatagraphyForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CatagraphyInfolist::configure($schema);
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return BeneficiaryResource::getRecordSubNavigation($page);
    }

    public static function getPages(): array
    {
        return [
            'index' => SummaryCatagraphy::route('/'),
            'view' => ViewCatagraphy::route('/view'),
            'edit' => EditCatagraphy::route('/edit'),
        ];
    }
}
