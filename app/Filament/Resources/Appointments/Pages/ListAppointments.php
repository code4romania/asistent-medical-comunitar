<?php

declare(strict_types=1);

namespace App\Filament\Resources\Appointments\Pages;

use App\Contracts\Pages\WithTabs;
use App\Filament\Resources\Appointments\AppointmentResource;
use App\Filament\Resources\Appointments\Concerns\HasTabs;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAppointments extends ListRecords implements WithTabs
{
    use HasTabs;

    protected static string $resource = AppointmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
