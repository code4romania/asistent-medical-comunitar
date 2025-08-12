<?php

declare(strict_types=1);

namespace App\Filament\Resources\BeneficiaryResource\Concerns;

use App\Filament\Actions\ActionGroup;
use App\Filament\Resources\AppointmentResource;
use App\Filament\Resources\InterventionResource\Actions\CreateCaseAction;
use App\Filament\Resources\InterventionResource\Actions\CreateIndividualServiceAction;
use Filament\Actions\Action;

trait HasActions
{
    protected function getActions(): array
    {
        return [
            ActionGroup::make([
                Action::make('catagraphy')
                    ->label(__('catagraphy.action.update'))
                    ->url(static::getResource()::getUrl('catagraphy.edit', $this->getBeneficiary())),

                CreateCaseAction::make()
                    ->after(fn () => $this->emit('updateInterventionsWidget'))
                    ->icon(null),

                CreateIndividualServiceAction::make()
                    ->after(fn () => $this->emit('updateInterventionsWidget'))
                    ->icon(null),

                Action::make('appointment')
                    ->label(__('appointment.action.create'))
                    ->url(AppointmentResource::getUrl('create', $this->getBeneficiary())),
            ]),
        ];
    }
}
