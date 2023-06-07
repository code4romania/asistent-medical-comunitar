<?php

declare(strict_types=1);

namespace App\Filament\Resources\AppointmentResource\Pages;

use App\Contracts\Forms\FixedActionBar;
use App\Filament\Resources\AppointmentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateAppointment extends CreateRecord implements FixedActionBar
{
    protected static string $resource = AppointmentResource::class;

    protected static bool $canCreateAnother = false;
}
