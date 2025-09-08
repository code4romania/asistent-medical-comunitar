<?php

declare(strict_types=1);

namespace App\Filament\Resources\Appointments\Pages;

use App\Filament\Resources\Appointments\Concerns\HasTabs;
use App\Contracts\Pages\WithTabs;
use App\Filament\Resources\Appointments\AppointmentResource;
use App\Filament\Resources\AppointmentResource\Concerns;
use App\Filament\Resources\Appointments\Widgets\CalendarWidget;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\Page;

class CalendarAppointments extends Page implements WithTabs
{
    use HasTabs;

    protected static string $resource = AppointmentResource::class;

    protected string $view = 'filament.resources.appointment-resource.pages.calendar-appointments';

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

    /**
     * Hack to show widget inside tab content.
     */
    public function getVisibleHeaderWidgets(): array
    {
        return [];
    }
}
