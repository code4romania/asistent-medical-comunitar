<?php

declare(strict_types=1);

namespace App\Filament\Resources\Appointments\Pages;

use App\Filament\Resources\Appointments\AppointmentResource;
use Filament\Resources\Pages\Page;

class Calendar extends Page
{
    protected static string $resource = AppointmentResource::class;

    protected string $view = 'filament.resources.appointment-resource.pages.calendar';
}
