<?php

declare(strict_types=1);

namespace App\Filament\Resources\AppointmentResource\Pages;

use App\Contracts\Pages\WithTabs;
use App\Filament\Resources\AppointmentResource;
use App\Filament\Resources\AppointmentResource\Concerns;
use App\Filament\Resources\AppointmentResource\Widgets\CalendarWidget;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class CalendarAppointments extends ListRecords /* implements WithTabs */
{
    // use Concerns\HasTabs;

    protected static string $resource = AppointmentResource::class;

    protected static string $view = 'filament.resources.appointment-resource.pages.calendar-appointments';

    protected function getHeaderWidgets(): array
    {
        return [
            CalendarWidget::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
