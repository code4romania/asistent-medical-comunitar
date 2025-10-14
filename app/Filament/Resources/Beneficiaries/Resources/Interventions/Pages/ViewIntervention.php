<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Resources\Interventions\Pages;

use App\Filament\Resources\Beneficiaries\Resources\Interventions\InterventionResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewIntervention extends ViewRecord
{
    protected static string $resource = InterventionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
