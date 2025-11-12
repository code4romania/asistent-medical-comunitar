<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Resources\Documents\Pages;

use App\Filament\Resources\Beneficiaries\Concerns\UsesParentRecordSubNavigation;
use App\Filament\Resources\Beneficiaries\Resources\Documents\Concerns\HasBreadcrumbs;
use App\Filament\Resources\Beneficiaries\Resources\Documents\DocumentResource;
use App\Filament\Resources\Beneficiaries\Resources\Documents\Schemas\DocumentForm;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EditDocument extends EditRecord
{
    use HasBreadcrumbs;
    use UsesParentRecordSubNavigation;

    protected static string $resource = DocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return $this->getRecordTitle();
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make()
                    ->heading(__('document.summary'))
                    ->columns(2)
                    ->components(fn (Schema $schema) => DocumentForm::configure($schema)),
            ]);
    }
}
