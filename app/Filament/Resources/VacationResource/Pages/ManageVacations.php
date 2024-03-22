<?php

declare(strict_types=1);

namespace App\Filament\Resources\VacationResource\Pages;

use App\Filament\Resources\VacationResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageVacations extends ManageRecords
{
    protected static string $resource = VacationResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
