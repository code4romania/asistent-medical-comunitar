<?php

declare(strict_types=1);

namespace App\Filament\Resources\AppointmentResource\Pages;

use App\Contracts\Pages\WithTabs;
use App\Filament\Resources\AppointmentResource;
use App\Filament\Resources\AppointmentResource\Concerns;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAppointments extends ListRecords implements WithTabs
{
    use Concerns\HasTabs;

    protected static string $resource = AppointmentResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
