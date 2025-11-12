<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\Pages;

use App\Concerns\TabbedLayout;
use App\Contracts\Pages\WithTabs;
use App\Filament\Resources\Users\Concerns\HasBreadcrumbs;
use App\Filament\Resources\Users\UserResource;
use Filament\Actions\CreateAction;
use Filament\Facades\Filament;
use Filament\Navigation\NavigationItem;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Str;

abstract class ListUsers extends ListRecords implements WithTabs
{
    use HasBreadcrumbs;
    use TabbedLayout;

    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

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
