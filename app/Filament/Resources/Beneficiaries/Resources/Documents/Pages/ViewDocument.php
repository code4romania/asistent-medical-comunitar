<?php

namespace App\Filament\Resources\Beneficiaries\Resources\Documents\Pages;

use App\Filament\Resources\Beneficiaries\Resources\Documents\DocumentResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewDocument extends ViewRecord
{
    protected static string $resource = DocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
