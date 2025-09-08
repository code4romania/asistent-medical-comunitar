<?php

declare(strict_types=1);

namespace App\Tables\Columns;

use Filament\Actions\ViewAction;
use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use App\Models\Intervention;
use App\Models\Intervention\InterventionableCase;
use App\Models\Intervention\InterventionableIndividualService;
use Filament\Tables\Columns\Column;
use Illuminate\Support\Arr;

class InterventionsColumn extends Column
{
    protected string $view = 'tables.columns.interventions-column';

    public function getAppointments(Intervention $intervention): array
    {
        return match (\get_class($intervention->interventionable)) {
            InterventionableCase::class => $intervention->appointments->all(),
            InterventionableIndividualService::class => Arr::wrap($intervention->appointment),
        };
    }

    public function getActions(Intervention $intervention): array
    {
        $url = BeneficiaryResource::getUrl('interventions.view', [
            'beneficiary' => $intervention->beneficiary_id,
            'record' => $intervention->id,
        ]);

        return [
            ViewAction::make()
                ->label(
                    $intervention->isCase()
                        ? __('intervention.action.view_case')
                        : __('intervention.action.view_individual')
                )
                ->record($intervention)
                ->color('primary')
                ->size('sm')
                ->icon(null)
                ->url($url),
        ];
    }
}
