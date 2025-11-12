<?php

declare(strict_types=1);

namespace App\Filament\Resources\CommunityActivities\Concerns;

use App\Filament\Resources\CommunityActivities\Actions\CreateAdministrativeActivityAction;
use App\Filament\Resources\CommunityActivities\Actions\CreateCampaignAction;
use Filament\Actions\ActionGroup;
use Filament\Support\Enums\IconPosition;
use Filament\Support\Icons\Heroicon;

trait HasActions
{
    protected function getHeaderActions(): array
    {
        return [
            ActionGroup::make([])
                ->label(__('app.action.group'))
                ->color('warning')
                ->button()
                ->icon(Heroicon::OutlinedChevronDown)
                ->iconPosition(IconPosition::After)
                ->actions([
                    CreateCampaignAction::make(),

                    CreateAdministrativeActivityAction::make(),
                ]),
        ];
    }
}
