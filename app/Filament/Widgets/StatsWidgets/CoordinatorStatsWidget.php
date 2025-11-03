<?php

declare(strict_types=1);

namespace App\Filament\Widgets\StatsWidgets;

use App\Filament\Resources\Users\UserResource;
use App\Filament\Widgets\Components\Stat;
use App\Models\Appointment;
use App\Models\Beneficiary;
use App\Models\Intervention;
use App\Models\User;
use App\Services\StatCount;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;

class CoordinatorStatsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 0;

    protected ?string $pollingInterval = null;

    public static function canView(): bool
    {
        return auth()->user()->isCoordinator();
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

    private function getAppointmentsStat(): Stat
    {
        $value = Appointment::select(StatCount::comparedBy('date'))
            ->toBase()
            ->first();

        return Stat::make(__('dashboard.stats.appointments'))
            ->icon(Heroicon::Calendar)
            ->trend($value);
    }

    private function getAllNursesStat(): Stat
    {
        $value = User::query()
            ->onlyNurses()
            ->activatesInCounty(auth()->user()->county_id)
            ->count();

        $url = UserResource::getUrl('index');

        return Stat::make(__('dashboard.stats.nurses_total'))
            ->icon(Heroicon::UserGroup)
            ->value($value)
            ->url($url);
    }

    private function getAllBeneficiariesStat(): Stat
    {
        $value = Beneficiary::count();

        return Stat::make(__('dashboard.stats.beneficiaries_total'))
            ->icon(Heroicon::UserGroup)
            ->value($value);
    }

    private function getActiveBeneficiariesStat(): Stat
    {
        $value = Beneficiary::query()
            ->onlyActive()
            ->count();

        return Stat::make(__('dashboard.stats.beneficiaries_active'))
            ->icon(Heroicon::Users)
            ->value($value);
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
}
