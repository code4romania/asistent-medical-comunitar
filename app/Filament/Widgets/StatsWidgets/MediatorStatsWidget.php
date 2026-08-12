<?php

declare(strict_types=1);

namespace App\Filament\Widgets\StatsWidgets;

use App\Filament\Resources\Appointments\AppointmentResource;
use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use App\Filament\Widgets\Components\Stat;
use Filament\Support\Icons\Heroicon;

class MediatorStatsWidget extends StatsOverviewWidget
{
    public static function canView(): bool
    {
        return auth()->user()->isMediator();
    }

    protected function getStats(): array
    {
        $mediatorId = auth()->id();

        $stats = static::cache("mediator-stats-widget:mediator:$mediatorId", fn (): array => [
            'beneficiaries_total' => static::allBeneficiariesCount(),
            'beneficiaries_active' => static::activeBeneficiariesCount(),
            'services' => static::realizedServicesTrend(),
            'appointments' => static::appointmentsTrend(),

        ]);

        return [
            Stat::make(__('dashboard.stats.beneficiaries_total'))
                ->icon(Heroicon::UserGroup)
                ->value($stats['beneficiaries_total'])
                ->url(BeneficiaryResource::getUrl('index')),

            Stat::make(__('dashboard.stats.beneficiaries_active'))
                ->icon(Heroicon::Users)
                ->value($stats['beneficiaries_active'])
                ->url(
                    BeneficiaryResource::getUrl('index', [
                        'filters' => [
                            'status' => [
                                'values' => [
                                    'active',
                                ],
                            ],
                        ],
                    ])
                ),

            Stat::make(__('dashboard.stats.services'))
                ->icon(Heroicon::Bolt)
                ->trend($stats['services']),

            Stat::make(__('dashboard.stats.appointments'))
                ->icon(Heroicon::CalendarDays)
                ->trend($stats['appointments'])
                ->url(AppointmentResource::getUrl('index')),
        ];
    }
}
