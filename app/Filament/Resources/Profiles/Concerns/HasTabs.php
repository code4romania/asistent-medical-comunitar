<?php

declare(strict_types=1);

namespace App\Filament\Resources\Profiles\Concerns;

use App\Concerns\TabbedLayout;
use Filament\Navigation\NavigationItem;
use Illuminate\Support\Str;

trait HasTabs
{
    use TabbedLayout;

    public function getTabsNavigation(): array
    {
        return [

            NavigationItem::make()
                ->label(__('user.profile.section.general'))
                ->icon('icon-none')
                ->url($this->getPageUrl('general.view'))
                ->isActiveWhen(fn (): bool => $this->isActiveWhen('general')),

            NavigationItem::make()
                ->label(__('user.profile.section.studies'))
                ->icon('icon-none')
                ->url($this->getPageUrl('studies.view'))
                ->isActiveWhen(fn (): bool => $this->isActiveWhen('studies')),

            NavigationItem::make()
                ->label(__('user.profile.section.employers'))
                ->icon('icon-none')
                ->url($this->getPageUrl('employers.view'))
                ->isActiveWhen(fn (): bool => $this->isActiveWhen('employers')),

            NavigationItem::make()
                ->label(__('user.profile.section.area'))
                ->icon('icon-none')
                ->url($this->getPageUrl('area.view'))
                ->isActiveWhen(fn (): bool => $this->isActiveWhen('area')),

        ];
    }

    public function getActiveTab(): string
    {
        return Str::of(static::class)
            ->classBasename()
            ->kebab()
            ->explode('-')
            ->last();
    }

    private function isActiveWhen(string $page): bool
    {
        return request()->routeIs([
            "filament.admin.resources.profile.$page.*",
            "filament.admin.resources.users.$page.*",
        ]);
    }
}
