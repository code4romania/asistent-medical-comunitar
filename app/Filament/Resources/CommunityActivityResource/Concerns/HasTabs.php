<?php

declare(strict_types=1);

namespace App\Filament\Resources\CommunityActivityResource\Concerns;

use App\Concerns\TabbedLayout;
use App\Filament\Resources\CommunityActivityResource;
use App\Filament\Resources\CommunityActivityResource\Pages\ManageAdministrativeActivities;
use App\Filament\Resources\CommunityActivityResource\Pages\ManageCampaigns;
use Filament\Navigation\NavigationItem;

trait HasTabs
{
    use TabbedLayout;

    public function getTabs(): array
    {
        return [

            NavigationItem::make()
                ->label(__('community_activity.section.campaign'))
                ->icon('icon-none')
                ->url(CommunityActivityResource::getUrl('index'))
                ->isActiveWhen(fn (): bool => static::class === ManageCampaigns::class),

            NavigationItem::make()
                ->label(__('community_activity.section.administrative'))
                ->icon('icon-none')
                ->url(CommunityActivityResource::getUrl('administrative'))
                ->isActiveWhen(fn (): bool => static::class === ManageAdministrativeActivities::class),

        ];
    }

    public function isTableSelectionEnabled(): bool
    {
        return false;
    }

    public function getHeading(): string
    {
        return __('community_activity.header.list');
    }

    protected function getBreadcrumbs(): array
    {
        return [];
    }
}
