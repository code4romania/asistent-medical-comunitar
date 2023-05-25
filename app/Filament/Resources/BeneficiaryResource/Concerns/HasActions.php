<?php

declare(strict_types=1);

namespace App\Filament\Resources\BeneficiaryResource\Concerns;

use App\Filament\Actions\ActionGroup;
use Filament\Pages\Actions\Action;

trait HasActions
{
    protected function getActions(): array
    {
        $record = static::getRecord();

        return [
            ActionGroup::make([
                Action::make('catagraphy')
                    ->label(__('catagraphy.action.update'))
                    ->url(static::getResource()::getUrl('catagraphy.edit', $this->getBeneficiary())),

                // Action::make('case_management')
                //     ->label(__('case_management.action.create'))
                //     ->url('#'),

                // Action::make('service')
                //     ->label(__('service.action.create'))
                //     ->url('#'),

                // Action::make('appointment')
                //     ->label(__('appointment.action.create'))
                //     ->url('#'),
            ]),
        ];
    }
}
