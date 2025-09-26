<?php

declare(strict_types=1);

namespace App\Filament\Resources\Appointments\Concerns;

use App\Concerns\TabbedLayout;
use App\Filament\Resources\Appointments\Pages\CalendarAppointments;
use App\Filament\Resources\Appointments\Pages\ListAppointments;
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
                ->isActiveWhen(fn (): bool => static::class === CalendarAppointments::class),

            NavigationItem::make()
                ->label(__('appointment.section.index'))
                ->icon('icon-none')
                ->url(static::getResource()::getUrl('list'))
                ->isActiveWhen(fn (): bool => static::class === ListAppointments::class),

        ];
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
