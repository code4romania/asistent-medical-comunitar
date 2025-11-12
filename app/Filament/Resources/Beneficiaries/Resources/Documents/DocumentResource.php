<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Resources\Documents;

use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use App\Filament\Resources\Beneficiaries\Concerns\HasBreadcrumbs;
use App\Filament\Resources\Beneficiaries\Resources\Documents\Pages\EditDocument;
use App\Filament\Resources\Beneficiaries\Resources\Documents\Pages\ViewDocument;
use App\Filament\Resources\Beneficiaries\Resources\Documents\Schemas\DocumentForm;
use App\Filament\Resources\Beneficiaries\Resources\Documents\Schemas\DocumentInfolist;
use App\Filament\Resources\Beneficiaries\Resources\Documents\Tables\DocumentsTable;
use App\Models\Document;
use Filament\Resources\Pages\Page;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

class DocumentResource extends Resource
{
    use HasBreadcrumbs;

    protected static ?string $model = Document::class;

    protected static ?string $parentResource = BeneficiaryResource::class;

    public static function getModelLabel(): string
    {
        return __('document.label.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('document.label.plural');
    }

    public static function form(Schema $schema): Schema
    {
        return DocumentForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DocumentInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DocumentsTable::configure($table);
    }

    public static function getRecordSubNavigation(Page $page): array
    {
        return BeneficiaryResource::getRecordSubNavigation($page);
    }

    public static function getPages(): array
    {
        return [
            'view' => ViewDocument::route('/{record}'),
            'edit' => EditDocument::route('/{record}/edit'),
        ];
    }
}
