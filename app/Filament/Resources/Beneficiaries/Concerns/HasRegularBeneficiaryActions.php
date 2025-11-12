<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Concerns;

use App\Filament\Resources\Appointments\AppointmentResource;
use App\Filament\Resources\Beneficiaries\Resources\Catagraphies\CatagraphyResource;
use App\Filament\Resources\Beneficiaries\Resources\Interventions\Actions\CreateCaseAction;
use App\Filament\Resources\Beneficiaries\Resources\Interventions\Actions\CreateIndividualServiceAction;
use App\Models\Beneficiary;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Support\Enums\IconPosition;
use Filament\Support\Icons\Heroicon;

trait HasRegularBeneficiaryActions
{
    protected function getHeaderActions(): array
    {
        /** @var Beneficiary */
        $beneficiary = $this->getParentRecord() ?? $this->getRecord();

        return [
            ActionGroup::make([])
                ->label(__('app.action.group'))
                ->color('warning')
                ->button()
                ->icon(Heroicon::OutlinedChevronDown)
                ->iconPosition(IconPosition::After)
                ->actions([
                    Action::make('catagraphy')
                        ->label(__('catagraphy.action.update'))
                        ->url(CatagraphyResource::getUrl('edit', [
                            'beneficiary' => $beneficiary,
                        ])),

                    CreateCaseAction::make()
                        ->icon(null),

                    CreateIndividualServiceAction::make()
                        ->icon(null),

                    Action::make('appointment')
                        ->label(__('appointment.action.create'))
                        ->url(AppointmentResource::getUrl('create', [
                            'beneficiary' => $beneficiary,
                        ])),
                ]),
        ];
    }
}
