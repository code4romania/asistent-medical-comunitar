<?php

declare(strict_types=1);

namespace App\Filament\Widgets\StatsWidget;

use App\Filament\Resources\AppointmentResource;
use App\Filament\Resources\BeneficiaryResource;
use App\Filament\Widgets\StatsWidget\Components\Card;
use App\Models\Appointment;
use App\Models\Beneficiary;
use App\Models\Intervention;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Tpetry\QueryExpressions\Function\Aggregate\CountFilter;
use Tpetry\QueryExpressions\Language\Alias;
use Tpetry\QueryExpressions\Operator\Comparison\Between;
use Tpetry\QueryExpressions\Value\Value;

class NurseStatsWidget extends BaseWidget
{
    protected static ?int $sort = 0;

    protected static ?string $pollingInterval = null;

    protected static string $view = 'filament.widgets.stats-overview-widget';

    public static function canView(): bool
    {
        return auth()->user()->isNurse();
    }

    public function getHeading(): string
    {
        return __('dashboard.stats.heading');
    }

    protected function getCards(): array
    {
        return [
            $this->getAllBeneficiariesCard(),
            $this->getActiveBeneficiariesCard(),
            $this->getRealizedServicesCard(),
            $this->getAppointmentsCard(),
        ];
    }

    private function getAllBeneficiariesCard(): Card
    {
        $value = Beneficiary::count();

        return Card::make(__('dashboard.stats.beneficiaries_total'), $value)
            ->icon('heroicon-s-user-group')
            ->url(BeneficiaryResource::getUrl('index'));
    }

    private function getActiveBeneficiariesCard(): Card
    {
        $value = Beneficiary::query()
            ->onlyActive()
            ->count();

        return Card::make(__('dashboard.stats.beneficiaries_active'), $value)
            ->icon('heroicon-s-user-group')
            ->url(
                BeneficiaryResource::getUrl('index', [
                    'tableFilters' => [
                        'status' => [
                            'values' => [
                                'active',
                            ],
                        ],
                    ],
                ])
            );
    }

    private function getRealizedServicesCard(): Card
    {
        return Card::make(__('dashboard.stats.services'))
            ->icon('heroicon-s-lightning-bolt')
            ->trend(
                Intervention::select(static::countsComparedBy('closed_at'))
                    ->onlyIndividualServices()
                    ->onlyRealized()
                    ->toBase()
                    ->first()
            );
    }

    private function getAppointmentsCard(): Card
    {
        return Card::make(__('dashboard.stats.appointments'))
            ->icon('heroicon-s-calendar')
            ->url(AppointmentResource::getUrl('index'))
            ->trend(
                Appointment::select(static::countsComparedBy('date'))
                    ->toBase()
                    ->first()
            );
    }

    private static function countsComparedBy(string $column): array
    {
        $today = today()->toDateString();
        $oneMonthAgo = today()->subMonth()->toDateString();
        $twoMonthsAgo = today()->subMonths(2)->toDateString();

        return [
            new Alias(new CountFilter(new Between($column, new Value($oneMonthAgo), new Value($today))), 'current'),
            new Alias(new CountFilter(new Between($column, new Value($twoMonthsAgo), new Value($oneMonthAgo))), 'previous'),
        ];
    }
}
