<?php

declare(strict_types=1);

namespace App\Concerns\Profile;

use App\Concerns\TabbedLayout;
use App\Filament\Resources\ProfileResource;
use Filament\Navigation\NavigationItem;
use Illuminate\Support\Str;

trait Tabs
{
    use TabbedLayout;

    public function getTabs(): array
    {
        return [
            NavigationItem::make()
                ->label(__('user.profile.section.general'))
                ->icon('heroicon-o-home')
                ->url(ProfileResource::getUrl('general.view'))
                ->isActiveWhen(fn (): bool => request()->routeIs('filament.resources.profile.general.*')),

            NavigationItem::make()
                ->label(__('user.profile.section.studies'))
                ->icon('heroicon-o-home')
                ->url(ProfileResource::getUrl('studies.view'))
                ->isActiveWhen(fn (): bool => request()->routeIs('filament.resources.profile.studies.*')),

            NavigationItem::make()
                ->label(__('user.profile.section.employers'))
                ->icon('heroicon-o-home')
                ->url(ProfileResource::getUrl('employers.view'))
                ->isActiveWhen(fn (): bool => request()->routeIs('filament.resources.profile.employers.*')),

            NavigationItem::make()
                ->label(__('user.profile.section.area'))
                ->icon('heroicon-o-home')
                ->url(ProfileResource::getUrl('area.view'))
                ->isActiveWhen(fn (): bool => request()->routeIs('filament.resources.profile.area.*')),

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
}
