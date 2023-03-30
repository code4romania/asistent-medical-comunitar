<?php

declare(strict_types=1);

namespace App\Filament\Resources\BeneficiaryResource\Concerns;

use Filament\Pages\Actions\Action;
use Filament\Pages\Actions\ActionGroup;

trait HasActions
{
    protected function getActions(): array
    {
        $record = static::getRecord();

        return [
            ActionGroup::make([
                Action::make('catagraphy')
                    ->label(__('catagraphy.action.update'))
                    ->url(static::getResource()::getUrl('catagraphy.edit', $record)),

                Action::make('case_management')
                    ->label(__('case_management.action.create'))
                    ->url('#'),

                Action::make('service')
                    ->label(__('service.action.create'))
                    ->url('#'),

                Action::make('appointment')
                    ->label(__('appointment.action.create'))
                    ->url('#'),
            ]),
        ];
    }
}
