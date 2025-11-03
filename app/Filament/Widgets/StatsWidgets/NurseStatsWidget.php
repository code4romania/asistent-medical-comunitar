<?php

declare(strict_types=1);

namespace App\Filament\Widgets\StatsWidgets;

use App\Filament\Resources\Appointments\AppointmentResource;
use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use App\Filament\Widgets\Components\Stat;
use App\Models\Appointment;
use App\Models\Beneficiary;
use App\Models\Intervention;
use App\Services\StatCount;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;

class NurseStatsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 0;

    protected ?string $pollingInterval = null;

    public static function canView(): bool
    {
        return auth()->user()->isNurse();
    }

    public function getHeading(): string
    {
        return __('dashboard.stats.heading');
    }

    protected function getStats(): array
    {
        return [
            $this->getAllBeneficiariesStat(),
            $this->getActiveBeneficiariesStat(),
            $this->getRealizedServicesStat(),
            $this->getAppointmentsStat(),
        ];
    }

    private function getAllBeneficiariesStat(): Stat
    {
        $value = Beneficiary::count();

        $url = BeneficiaryResource::getUrl('index');

        return Stat::make(__('dashboard.stats.beneficiaries_total'))
            ->icon(Heroicon::UserGroup)
            ->value($value)
            ->url($url);
    }

    private function getActiveBeneficiariesStat(): Stat
    {
        $value = Beneficiary::query()
            ->onlyActive()
            ->count();

        $url = BeneficiaryResource::getUrl('index', [
            'filters' => [
                'status' => [
                    'values' => [
                        'active',
                    ],
                ],
            ],
        ]);

        return Stat::make(__('dashboard.stats.beneficiaries_active'), $value)
            ->icon(Heroicon::Users)
            ->value($value)
            ->url($url);
    }

    private function getRealizedServicesStat(): Stat
    {
        $value = Intervention::select(StatCount::comparedBy('closed_at'))
            ->onlyIndividualServices()
            ->onlyRealized()
            ->toBase()
            ->first();

        return Stat::make(__('dashboard.stats.services'))
            ->icon(Heroicon::Bolt)
            ->trend($value);
    }

    private function getAppointmentsStat(): Stat
    {
        $value = Appointment::select(StatCount::comparedBy('date'))
            ->toBase()
            ->first();

        $url = AppointmentResource::getUrl('index');

        return Stat::make(__('dashboard.stats.appointments'), data_get($value, 'current'))
            ->icon(Heroicon::CalendarDays)
            ->trend($value)
            ->url($url);
    }
}
