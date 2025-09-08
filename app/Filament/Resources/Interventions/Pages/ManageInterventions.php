<?php

declare(strict_types=1);

namespace App\Filament\Resources\Interventions\Pages;

use App\Filament\Resources\Interventions\InterventionResource;
use Filament\Resources\Pages\ManageRecords;

class ManageInterventions extends ManageRecords
{
    protected static string $resource = InterventionResource::class;
}
