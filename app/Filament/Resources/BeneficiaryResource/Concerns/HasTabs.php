<?php

declare(strict_types=1);

namespace App\Filament\Resources\BeneficiaryResource\Concerns;

use App\Concerns\TabbedLayout;
use App\Filament\Resources\BeneficiaryResource;
use App\Filament\Resources\BeneficiaryResource\Pages\ListBeneficiaries;
use App\Filament\Resources\BeneficiaryResource\Pages\ListOcasionalBeneficiaries;
use App\Filament\Resources\BeneficiaryResource\Pages\ListRegularBeneficiaries;
use App\Filament\Resources\HouseholdResource;
use App\Filament\Resources\HouseholdResource\Pages\ManageHouseholds;
use Filament\Navigation\NavigationItem;

trait HasTabs
{
    use TabbedLayout;

    public function getTabs(): array
    {
        return [

            NavigationItem::make()
                ->label(__('beneficiary.section.index'))
                ->icon('heroicon-o-home')
                ->url(BeneficiaryResource::getUrl('index'))
                ->isActiveWhen(fn (): bool => static::class === ListBeneficiaries::class),

            NavigationItem::make()
                ->label(__('beneficiary.section.regular'))
                ->icon('heroicon-o-home')
                ->url(BeneficiaryResource::getUrl('regular'))
                ->isActiveWhen(fn (): bool => static::class === ListRegularBeneficiaries::class),

            NavigationItem::make()
                ->label(__('beneficiary.section.ocasional'))
                ->icon('heroicon-o-home')
                ->url(BeneficiaryResource::getUrl('ocasional'))
                ->isActiveWhen(fn (): bool => static::class === ListOcasionalBeneficiaries::class),

            NavigationItem::make()
                ->label(__('beneficiary.section.households'))
                ->icon('heroicon-o-home')
                ->url(HouseholdResource::getUrl('index'))
                ->isActiveWhen(fn (): bool => static::class === ManageHouseholds::class),

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
}
