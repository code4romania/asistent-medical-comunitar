<?php

declare(strict_types=1);

namespace App\Filament\Widgets\StatsWidgets;

use App\Filament\Resources\Users\UserResource;
use App\Filament\Widgets\Components\Stat;
use Filament\Support\Icons\Heroicon;

class CoordinatorStatsWidget extends StatsOverviewWidget
{
    public static function canView(): bool
    {
        return auth()->user()->isCoordinator();
    }

    protected function getColumns(): int|array
    {
        return [
            'md' => 3,
            'xl' => 5,
        ];
    }

    protected function getStats(): array
    {
        $countyId = auth()->user()->county_id;

        $stats = static::cache("coordinator-stats-widget:county:$countyId", fn (): array => [
            'appointments' => static::appointmentsTrend(),
            'nurses_total' => static::allNursesCount($countyId),
            'beneficiaries_total' => static::allBeneficiariesCount(),
            'beneficiaries_active' => static::activeBeneficiariesCount(),
            'services' => static::realizedServicesTrend(),
        ]);

        return [
            Stat::make(__('dashboard.stats.appointments'))
                ->icon(Heroicon::Calendar)
                ->trend($stats['appointments']),

            Stat::make(__('dashboard.stats.nurses_total'))
                ->icon(Heroicon::UserGroup)
                ->value($stats['nurses_total'])
                ->url(UserResource::getUrl('index')),

            Stat::make(__('dashboard.stats.beneficiaries_total'))
                ->icon(Heroicon::UserGroup)
                ->value($stats['beneficiaries_total']),

            Stat::make(__('dashboard.stats.beneficiaries_active'))
                ->icon(Heroicon::Users)
                ->value($stats['beneficiaries_active']),

            Stat::make(__('dashboard.stats.services'))
                ->icon(Heroicon::Bolt)
                ->trend($stats['services']),
        ];
    }
}
