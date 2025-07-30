<?php

declare(strict_types=1);

namespace App\Filament\Resources\AppointmentResource\Pages;

use App\Contracts\Pages\WithTabs;
use App\Filament\Resources\AppointmentResource;
use App\Filament\Resources\AppointmentResource\Concerns;
use App\Filament\Resources\AppointmentResource\Widgets\CalendarWidget;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class CalendarAppointments extends ListRecords implements WithTabs
{
    use Concerns\HasTabs;

    protected static string $resource = AppointmentResource::class;

    protected static string $view = 'filament.resources.appointment-resource.pages.calendar-appointments';

    protected function calendar(): array
    {
        return [
            CalendarWidget::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
