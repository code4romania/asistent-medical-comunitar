<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Resources\Interventions\Pages;

use App\Filament\Resources\Beneficiaries\Resources\Interventions\InterventionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateIntervention extends CreateRecord
{
    protected static string $resource = InterventionResource::class;
}
