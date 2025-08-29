<?php

declare(strict_types=1);

namespace App\Filament\Resources\UserResource\Concerns;

use App\Concerns\TabbedLayout;
use App\Filament\Resources\UserResource;
use App\Filament\Resources\UserResource\Pages\ListAdmins;
use App\Filament\Resources\UserResource\Pages\ListCoordinators;
use App\Filament\Resources\UserResource\Pages\ListNurses;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationItem;
use Illuminate\Support\Str;

trait HasTabs
{
    use TabbedLayout;

    public function getTabsNavigation(): array
    {
        return [

            NavigationItem::make()
                ->label(__('user.section.nurses'))
                ->icon('icon-none')
                ->url(UserResource::getUrl('index'))
                ->isActiveWhen(fn () => static::class === ListNurses::class)
                ->visible(fn () => true),

            NavigationItem::make()
                ->label(__('user.section.coordinators'))
                ->icon('icon-none')
                ->url(UserResource::getUrl('coordinators'))
                ->isActiveWhen(fn () => static::class === ListCoordinators::class)
                ->visible(fn () => Filament::auth()->user()->isAdmin()),

            NavigationItem::make()
                ->label(__('user.section.admins'))
                ->icon('icon-none')
                ->url(UserResource::getUrl('admins'))
                ->isActiveWhen(fn () => static::class === ListAdmins::class)
                ->visible(fn () => Filament::auth()->user()->isAdmin()),

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
