<?php

declare(strict_types=1);

namespace App\Filament\Resources\AppointmentResource\Pages;

use App\Contracts\Forms\FixedActionBar;
use App\Filament\Resources\AppointmentResource;
use Filament\Resources\Pages\EditRecord;

class EditAppointment extends EditRecord implements FixedActionBar
{
    protected static string $resource = AppointmentResource::class;

    protected function getActions(): array
    {
        return [
            //
        ];
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('view', $this->getRecord());
    }
}
