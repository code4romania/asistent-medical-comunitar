<?php

declare(strict_types=1);

namespace App\Filament\Resources\CommunityActivities\Concerns;

use Filament\Actions\CreateAction;
use App\Concerns\HasConditionalTableEmptyState;
use App\Enums\CommunityActivity\Type;
use App\Filament\Resources\CommunityActivities\CommunityActivityResource;
use App\Filament\Resources\CommunityActivities\Pages\ManageAdministrativeActivities;
use App\Filament\Resources\CommunityActivities\Pages\ManageCampaigns;
use App\Models\CommunityActivity;

trait HasEmptyState
{
    use HasConditionalTableEmptyState;

    protected function getTableEmptyStateIcon(): ?string
    {
        if ($this->hasAlteredTableQuery()) {
            return null;
        }

        return 'icon-empty-state';
    }

    protected function getTableEmptyStateHeading(): ?string
    {
        if ($this->hasAlteredTableQuery()) {
            return null;
        }

        return __('community_activity.empty.title');
    }

    protected function getTableEmptyStateDescription(): ?string
    {
        if ($this->hasAlteredTableQuery()) {
            return null;
        }

        return __('community_activity.empty.description');
    }

    protected function getTableEmptyStateActions(): array
    {
        return [
            CreateAction::make()
                ->label(fn ($livewire) => match (\get_class($livewire)) {
                    ManageCampaigns::class => __('community_activity.action.create_campaign'),
                    ManageAdministrativeActivities::class => __('community_activity.action.create_administrative'),
                })
                ->modalHeading(fn ($livewire) => match (\get_class($livewire)) {
                    ManageCampaigns::class => __('community_activity.action.create_campaign'),
                    ManageAdministrativeActivities::class => __('community_activity.action.create_administrative'),
                })
                ->schema(fn ($livewire) => match (\get_class($livewire)) {
                    ManageCampaigns::class => CommunityActivityResource::getCampaignEditFormSchema(),
                    ManageAdministrativeActivities::class => CommunityActivityResource::getAdministrativeEditFormSchema(),
                })
                ->using(function (array $data, $livewire) {
                    $data['type'] = match (\get_class($livewire)) {
                        ManageCampaigns::class => Type::CAMPAIGN,
                        ManageAdministrativeActivities::class => Type::ADMINISTRATIVE,
                    };

                    return CommunityActivity::create($data);
                })
                ->button()
                ->color('gray')
                ->authorize(CommunityActivityResource::canCreate())
                ->hidden(fn () => $this->hasAlteredTableQuery())
                ->createAnother(false),
        ];
    }
}
