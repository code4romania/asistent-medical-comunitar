<?php

declare(strict_types=1);

namespace App\Concerns\Beneficiary;

use App\Concerns\TabbedLayout;
use App\Filament\Resources\BeneficiaryResource;
use App\Filament\Resources\HouseholdResource;
use Filament\Navigation\NavigationItem;

trait Tabs
{
    use TabbedLayout;

    public function getTabs(): array
    {
        return [

            NavigationItem::make()
                ->label(__('beneficiary.section.index'))
                ->icon('heroicon-o-home')
                ->url(BeneficiaryResource::getUrl('index'))
                ->isActiveWhen(fn (): bool => request()->routeIs('filament.resources.beneficiaries.index')),

            NavigationItem::make()
                ->label(__('beneficiary.section.regular'))
                ->icon('heroicon-o-home')
                ->url(BeneficiaryResource::getUrl('regular'))
                ->isActiveWhen(fn (): bool => request()->routeIs('filament.resources.beneficiaries.regular')),

            NavigationItem::make()
                ->label(__('beneficiary.section.ocasional'))
                ->icon('heroicon-o-home')
                ->url(BeneficiaryResource::getUrl('ocasional'))
                ->isActiveWhen(fn (): bool => request()->routeIs('filament.resources.beneficiaries.ocasional')),

            NavigationItem::make()
                ->label(__('beneficiary.section.ocasional'))
                ->icon('heroicon-o-home')
                ->url(HouseholdResource::getUrl('index'))
                ->isActiveWhen(fn (): bool => request()->routeIs('filament.resources.households.index')),

        ];
    }

    protected function getBreadcrumbs(): array
    {
        return [];
    }

    protected function getTableEmptyStateIcon(): ?string
    {
        return 'icon-empty-state';
    }
}
