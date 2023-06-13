<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Enums\UserRole;
use App\Filament\Resources\AppointmentResource;
use App\Filament\Resources\BeneficiaryResource;
use App\Models\Appointment;
use App\Models\Beneficiary;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;
use Illuminate\Support\Facades\Cache;

class StatsOverviewWidget extends BaseWidget
{
    protected static ?int $sort = 0;

    protected static ?string $pollingInterval = null;

    protected static string $view = 'filament.widgets.stats-overview-widget';

    public function getHeading(): string
    {
        return __('dashboard.stats.heading');
    }

    protected function getCacheKey(): string
    {
        return 'dashboard-stats-user-' . auth()->user()->id;
    }

    protected function getCacheTTL(): int
    {
        return MINUTE_IN_SECONDS;
    }

    protected function getCards(): array
    {
        $stats = Cache::remember(
            $this->getCacheKey(),
            $this->getCacheTTL(),
            fn () => match (auth()->user()->role) {
                UserRole::ADMIN => $this->getAdminStats(),
                UserRole::NURSE => $this->getNurseStats(),
                default => null,
            }
        );

        return collect($stats)
            ->map(
                fn (array $stats, string $key) => Card::make(__("dashboard.stats.$key"), $stats['value'])
                    ->icon($stats['icon'] ?? null)
                    ->url($stats['url'] ?? null)
                    ->color($stats['color'] ?? null)
            )
            ->all();
    }

    protected function getNurseStats(): array
    {
        return [
            'beneficiaries_total' => [
                'icon' => 'heroicon-s-user-group',
                'url' => auth()->user()->isNurse()
                    ? BeneficiaryResource::getUrl('index')
                    : null,
                'value' => Beneficiary::query()
                    ->count(),
            ],

            'beneficiaries_active' => [
                'icon' => 'heroicon-s-user',
                'url' => auth()->user()->isNurse()
                    ? BeneficiaryResource::getUrl('index')
                    : null,
                'value' => Beneficiary::query()
                    ->onlyActive()
                    ->count(),
            ],

            'services' => [
                'icon' => 'heroicon-s-lightning-bolt',
                'value' => 0,
            ],

            'appointments' => [
                'icon' => 'heroicon-s-lightning-bolt',
                'url' => AppointmentResource::getUrl('index'),
                'value' => Appointment::query()
                    ->lastMonth()
                    ->count(),
            ],
        ];
    }

    protected function getAdminStats(): array
    {
        return [
            'beneficiaries_total' => [
                'icon' => 'heroicon-s-user-group',
                'url' => BeneficiaryResource::getUrl('index'),
                'value' => Beneficiary::query()
                    ->count(),
            ],

            'beneficiaries_active' => [
                'icon' => 'heroicon-s-user',
                'url' => BeneficiaryResource::getUrl('index'),
                'value' => Beneficiary::query()
                    ->onlyActive()
                    ->count(),
            ],

            'services' => [
                'icon' => 'heroicon-s-lightning-bolt',
                'value' => 0,
            ],

            'appointments' => [
                'icon' => 'heroicon-s-lightning-bolt',
                'value' => Appointment::query()
                    ->lastMonth()
                    ->count(),
            ],
        ];
    }
}
