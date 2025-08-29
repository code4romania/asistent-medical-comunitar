<?php

declare(strict_types=1);

namespace App\Filament\Resources\AppointmentResource\Concerns;

use App\Concerns\TabbedLayout;
use App\Filament\Resources\AppointmentResource\Pages;
use Filament\Navigation\NavigationItem;

trait HasTabs
{
    use TabbedLayout;

    public function getTabsNavigation(): array
    {
        return [

            NavigationItem::make()
                ->label(__('appointment.section.calendar'))
                ->icon('icon-none')
                ->url(static::getResource()::getUrl('index'))
                ->isActiveWhen(fn (): bool => static::class === Pages\CalendarAppointments::class),

            NavigationItem::make()
                ->label(__('appointment.section.index'))
                ->icon('icon-none')
                ->url(static::getResource()::getUrl('list'))
                ->isActiveWhen(fn (): bool => static::class === Pages\ListAppointments::class),

        ];
    }

    public function isTableSelectionEnabled(): bool
    {
        return false;
    }

    public function getHeading(): string
    {
        return __('appointment.label.plural');
    }

    public function getBreadcrumbs(): array
    {
        return [];
    }
}
