<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 0;

    protected static ?string $pollingInterval = null;

    protected static string $view = 'filament.widgets.stats-overview-widget';

    protected function getCards(): array
    {
        return [

            Card::make(__('dashboard.stats.beneficiaries_total'), 15)
                ->icon('heroicon-s-user')
                ->url('#')
                ->description('12%')
                ->descriptionIcon('heroicon-s-trending-up')
                ->color('success'),

            Card::make(__('dashboard.stats.beneficiaries_active'), 125)
                ->icon('heroicon-s-user')
                ->url('#')
                ->description('12%')
                ->descriptionIcon('heroicon-s-trending-up')
                ->color('success'),

            Card::make(__('dashboard.stats.services'), 878)
                ->icon('heroicon-s-lightning-bolt')
                ->url('#')
                ->description('12%')
                ->descriptionIcon('heroicon-s-trending-down')
                ->color('danger'),

            Card::make(__('dashboard.stats.appointments'), 78)
                ->icon('heroicon-s-lightning-bolt')
                ->url('#')
                ->description('12%')
                ->descriptionIcon('heroicon-s-trending-down')
                ->color('warning'),
        ];
    }

    public function getHeading(): string
    {
        return __('dashboard.stats.heading');
    }
}
