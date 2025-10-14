<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Resources\Interventions\Pages;

use App\Filament\Resources\Beneficiaries\Resources\Interventions\InterventionResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditIntervention extends EditRecord
{
    protected static string $resource = InterventionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
