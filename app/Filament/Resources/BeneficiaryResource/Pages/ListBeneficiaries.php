<?php

declare(strict_types=1);

namespace App\Filament\Resources\BeneficiaryResource\Pages;

use App\Concerns\Beneficiary\Tabs;
use App\Contracts\Pages\WithTabs;
use App\Filament\Resources\BeneficiaryResource;
use Filament\Pages;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables;

class ListBeneficiaries extends ListRecords implements WithTabs
{
    use Tabs;

    protected static string $resource = BeneficiaryResource::class;

    protected function getActions(): array
    {
        return [
            Pages\Actions\CreateAction::make(),
        ];
    }

    public function isTableSelectionEnabled(): bool
    {
        return false;
    }

    public function getHeading(): string
    {
        return __('beneficiary.header.list');
    }

    protected function getBreadcrumbs(): array
    {
        return [];
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
}
