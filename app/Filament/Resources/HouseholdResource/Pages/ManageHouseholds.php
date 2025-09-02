<?php

declare(strict_types=1);

namespace App\Filament\Resources\HouseholdResource\Pages;

use App\Concerns\HasConditionalTableEmptyState;
use App\Contracts\Pages\WithTabs;
use App\Filament\Resources\BeneficiaryResource;
use App\Filament\Resources\HouseholdResource;
use App\Models\Household;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;
use Filament\Tables;

class ManageHouseholds extends ManageRecords implements WithTabs
{
    use HasConditionalTableEmptyState;
    use BeneficiaryResource\Concerns\HasRecordBreadcrumb;
    use BeneficiaryResource\Concerns\HasTabs;

    protected static string $resource = HouseholdResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->using(fn (array $data) => Household::createForCurrentNurse($data))
                ->createAnother(false),
        ];
    }

    protected function getTableEmptyStateIcon(): ?string
    {
        if ($this->hasAlteredTableQuery()) {
            return null;
        }

        return 'icon-empty-state';
    }

    protected function getTableEmptyStateHeading(): ?string
    {
        if ($this->hasAlteredTableQuery()) {
            return null;
        }

        return __('household.empty.title');
    }

    protected function getTableEmptyStateDescription(): ?string
    {
        if ($this->hasAlteredTableQuery()) {
            return null;
        }

        return __('household.empty.description');
    }

    protected function getTableEmptyStateActions(): array
    {
        return [
            Tables\Actions\CreateAction::make()
                ->label(__('household.empty.create'))
                ->modalHeading(__('household.empty.create'))
                ->button()
                ->color('gray')
                ->createAnother(false)
                ->form(HouseholdResource::getFormSchema())
                ->using(fn (array $data) => Household::createForCurrentNurse($data))
                ->hidden(fn () => $this->hasAlteredTableQuery()),
        ];
    }
}
