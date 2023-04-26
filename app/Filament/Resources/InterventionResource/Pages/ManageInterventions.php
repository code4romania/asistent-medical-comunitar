<?php

declare(strict_types=1);

namespace App\Filament\Resources\InterventionResource\Pages;

use App\Filament\Resources\InterventionResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageInterventions extends ManageRecords
{
    protected static string $resource = InterventionResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
