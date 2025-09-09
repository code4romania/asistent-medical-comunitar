<?php

declare(strict_types=1);

namespace App\Filament\Widgets\StatsWidgets;

use App\Filament\Resources\Users\UserResource;
use App\Models\Appointment;
use App\Models\Beneficiary;
use App\Models\Intervention;
use App\Models\User;
use App\Services\StatCount;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AdminStatsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 0;

    protected ?string $pollingInterval = null;

    public static function canView(): bool
    {
        return auth()->user()->isAdmin();
    }

    public function getHeading(): string
    {
        return __('dashboard.stats.heading');
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
        return [
            $this->getAppointmentsStat(),
            $this->getAllNursesStat(),
            $this->getAllBeneficiariesStat(),
            $this->getActiveBeneficiariesStat(),
            $this->getRealizedServicesStat(),
        ];
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

    /**
     * @TODO: implement url
     */
    private function getAllNursesStat(): Stat
    {
        $value = User::query()
            ->onlyNurses()
            ->count();

        return Stat::make(__('dashboard.stats.nurses_total'), $value)
            ->icon(Heroicon::UserGroup);
        // ->url(UserResource::getUrl('index'));
    }

    private function getAllBeneficiariesStat(): Stat
    {
        $value = Beneficiary::count();

        return Stat::make(__('dashboard.stats.beneficiaries_total'), $value)
            ->icon(Heroicon::UserGroup);
    }

    private function getActiveBeneficiariesStat(): Stat
    {
        $value = Beneficiary::query()
            ->onlyActive()
            ->count();

        return Stat::make(__('dashboard.stats.beneficiaries_active'), $value)
            ->icon(Heroicon::UserGroup);
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
}
