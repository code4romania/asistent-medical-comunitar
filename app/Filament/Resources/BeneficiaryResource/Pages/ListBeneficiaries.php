<?php

declare(strict_types=1);

namespace App\Filament\Resources\BeneficiaryResource\Pages;

use App\Contracts\Pages\WithTabs;
use App\Filament\Resources\BeneficiaryResource;
use App\Filament\Resources\BeneficiaryResource\Concerns;
use Filament\Pages;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables;

class ListBeneficiaries extends ListRecords implements WithTabs
{
    use Concerns\HasRecordBreadcrumb;
    use Concerns\HasTabs;

    protected static string $resource = BeneficiaryResource::class;

    protected function getActions(): array
    {
        return [
            Pages\Actions\CreateAction::make(),
        ];
    }

    protected function getTableEmptyStateIcon(): ?string
    {
        return 'icon-empty-state';
    }

    protected function getTableEmptyStateHeading(): ?string
    {
        return __('beneficiary.empty.title');
    }

    protected function getTableEmptyStateDescription(): ?string
    {
        return __('beneficiary.empty.description');
    }

    protected function getTableEmptyStateActions(): array
    {
        return [
            Tables\Actions\Action::make('create')
                ->label(__('beneficiary.empty.create'))
                ->url(static::getResource()::getUrl('create'))
                ->button()
                ->color('secondary'),
        ];
    }

    protected function getRelationManagers(): array
    {
        return [];
    }
}
