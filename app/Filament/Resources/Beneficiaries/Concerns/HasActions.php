<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Concerns;

use App\Filament\Actions\ActionGroup;
use App\Filament\Resources\Appointments\AppointmentResource;
use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use App\Filament\Resources\Interventions\Actions\CreateCaseAction;
use App\Filament\Resources\Interventions\Actions\CreateIndividualServiceAction;
use Filament\Actions\Action;

trait HasActions
{
    protected function getActions(): array
    {
        return [
            ActionGroup::make([
                Action::make('catagraphy')
                    ->label(__('catagraphy.action.update'))
                    ->url(BeneficiaryResource::getUrl('catagraphy.edit', [
                        'record' => $this->getBeneficiary(),
                    ])),

                CreateCaseAction::make()
                    ->after(fn () => $this->emit('updateInterventionsWidget'))
                    ->icon(null),

                CreateIndividualServiceAction::make()
                    ->after(fn () => $this->emit('updateInterventionsWidget'))
                    ->icon(null),

                Action::make('appointment')
                    ->label(__('appointment.action.create'))
                    ->url(AppointmentResource::getUrl('create', [
                        'beneficiary' => $this->getBeneficiary(),
                    ])),
            ]),
        ];
    }
}
