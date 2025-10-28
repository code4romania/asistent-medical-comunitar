<?php

declare(strict_types=1);

namespace App\Filament\Resources\CommunityActivities\Concerns;

use App\Concerns\TabbedLayout;
use App\Filament\Resources\CommunityActivities\CommunityActivityResource;
use App\Filament\Resources\CommunityActivities\Pages\ManageAdministrativeActivities;
use App\Filament\Resources\CommunityActivities\Pages\ManageCampaigns;
use Filament\Navigation\NavigationItem;

trait HasTabs
{
    use TabbedLayout;

    public function getTabsNavigation(): array
    {
        return [

            NavigationItem::make()
                ->label(__('community_activity.section.campaign'))
                ->icon('icon-none')
                ->url(CommunityActivityResource::getUrl('index'))
                ->isActiveWhen(fn () => static::class === ManageCampaigns::class),

            NavigationItem::make()
                ->label(__('community_activity.section.administrative'))
                ->icon('icon-none')
                ->url(CommunityActivityResource::getUrl('administrative'))
                ->isActiveWhen(fn (): bool => static::class === ManageAdministrativeActivities::class),

        ];
    }

    public function getHeading(): string
    {
        return __('community_activity.header.list');
    }

    public function getBreadcrumbs(): array
    {
        return [];
    }
}
