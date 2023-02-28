<?php

declare(strict_types=1);

namespace App\Filament\Resources\HouseholdResource\Pages;

use App\Concerns\Beneficiary\Tabs;
use App\Contracts\Pages\WithTabs;
use App\Filament\Resources\HouseholdResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;
use Filament\Tables\Actions\Modal\Actions\Action;

class ManageHouseholds extends ManageRecords implements WithTabs
{
    use Tabs;

    protected static string $resource = HouseholdResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->disableCreateAnother(),
        ];
    }

    protected function getTableEmptyStateIcon(): ?string
    {
        return 'icon-empty-state';
    }

    protected function getTableEmptyStateHeading(): ?string
    {
        return __('household.empty.title');
    }

    protected function getTableEmptyStateDescription(): ?string
    {
        return __('household.empty.description');
    }

    protected function getTableEmptyStateActions(): array
    {
        return [
            // Action::make('create')
            //     ->label(__('household.empty.create'))
            //     ->button()
            //     ->color('secondary'),
        ];
    }
}
