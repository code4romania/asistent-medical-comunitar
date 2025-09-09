<?php

declare(strict_types=1);

namespace App\Filament\Widgets\StatsWidgets;

use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use App\Models\Appointment;
use App\Models\Beneficiary;
use App\Models\Intervention;
use App\Services\StatCount;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

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

    /**
     * @TODO: implement url
     */
    private function getAllBeneficiariesStat(): Stat
    {
        $value = Beneficiary::count();

        return Stat::make(__('dashboard.stats.beneficiaries_total'), $value)
            ->icon(Heroicon::UserGroup);
        // ->url(BeneficiaryResource::getUrl('index'));
    }

    /**
     * @TODO: implement url
     */
    private function getActiveBeneficiariesStat(): Stat
    {
        $value = Beneficiary::query()
            ->onlyActive()
            ->count();

        return Stat::make(__('dashboard.stats.beneficiaries_active'), $value)
            ->icon(Heroicon::UserGroup);
        // ->url(
        //     BeneficiaryResource::getUrl('index', [
        //         'tableFilters' => [
        //             'status' => [
        //                 'values' => [
        //                     'active',
        //                 ],
        //             ],
        //         ],
        //     ])
        // );
    }

    /**
     * @TODO: implement trend
     */
    private function getRealizedServicesStat(): Stat
    {
        $value = Intervention::select(StatCount::comparedBy('closed_at'))
            ->onlyIndividualServices()
            ->onlyRealized()
            ->toBase()
            ->first();

        return Stat::make(__('dashboard.stats.services'), data_get($value, 'current'))
            ->icon(Heroicon::Bolt);
    }

    /**
     * @TODO: implement trend
     * @TODO: implement url
     */
    private function getAppointmentsStat(): Stat
    {
        $value = Appointment::select(StatCount::comparedBy('date'))
            ->toBase()
            ->first();

        return Stat::make(__('dashboard.stats.appointments'), data_get($value, 'current'))
            ->icon(Heroicon::Calendar);
        // ->url(AppointmentResource::getUrl('index'))
    }
}
