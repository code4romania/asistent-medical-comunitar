<?php

declare(strict_types=1);

namespace App\Filament\Resources\UserResource\Concerns;

use App\Concerns\TabbedLayout;
use App\Filament\Resources\UserResource;
use Filament\Navigation\NavigationItem;
use Illuminate\Support\Str;

trait HasTabs
{
    use TabbedLayout;

    public function getTabs(): array
    {
        return [

            NavigationItem::make()
                ->label(__('user.section.index'))
                ->icon('icon-none')
                ->url(UserResource::getUrl('index'))
                ->isActiveWhen(fn (): bool => request()->routeIs('filament.resources.users.index')),

            NavigationItem::make()
                ->label(__('user.section.active'))
                ->icon('icon-none')
                ->url(UserResource::getUrl('active'))
                ->isActiveWhen(fn (): bool => request()->routeIs('filament.resources.users.active')),

            NavigationItem::make()
                ->label(__('user.section.inactive'))
                ->icon('icon-none')
                ->url(UserResource::getUrl('inactive'))
                ->isActiveWhen(fn (): bool => request()->routeIs('filament.resources.users.inactive')),

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
