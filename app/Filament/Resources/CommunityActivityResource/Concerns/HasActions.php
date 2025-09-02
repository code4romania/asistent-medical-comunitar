<?php

declare(strict_types=1);

namespace App\Filament\Resources\CommunityActivityResource\Concerns;

use App\Enums\CommunityActivity\Type;
use App\Filament\Actions\ActionGroup;
use App\Filament\Resources\CommunityActivityResource;
use App\Models\CommunityActivity;
use Filament\Actions\CreateAction;

trait HasActions
{
    protected function getActions(): array
    {
        return [
            ActionGroup::make([

                CreateAction::make('campaign')
                    ->form(CommunityActivityResource::getCampaignEditFormSchema())
                    ->using(function (array $data) {
                        $data['type'] = Type::CAMPAIGN;

                        return CommunityActivity::create($data);
                    })
                    ->label(__('community_activity.action.create_campaign'))
                    ->modalHeading(__('community_activity.action.create_campaign'))
                    ->groupedIcon(null)
                    ->authorize(CommunityActivityResource::canCreate())
                    ->createAnother(false),

                CreateAction::make('admin')
                    ->form(CommunityActivityResource::getAdministrativeEditFormSchema())
                    ->using(function (array $data) {
                        $data['type'] = Type::ADMINISTRATIVE;

                        return CommunityActivity::create($data);
                    })
                    ->label(__('community_activity.action.create_administrative'))
                    ->modalHeading(__('community_activity.action.create_administrative'))
                    ->groupedIcon(null)
                    ->authorize(CommunityActivityResource::canCreate())
                    ->createAnother(false),

            ]),
        ];
    }
}
