<?php

namespace App\Filament\Resources\Beneficiaries\Resources\Documents\Pages;

use App\Filament\Resources\Beneficiaries\Resources\Documents\DocumentResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditDocument extends EditRecord
{
    protected static string $resource = DocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
