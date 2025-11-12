<?php

declare(strict_types=1);

namespace App\Filament\Resources\Vacations\Pages;

use App\Filament\Resources\Vacations\VacationResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageVacations extends ManageRecords
{
    protected static string $resource = VacationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
