<?php

declare(strict_types=1);

namespace App\Filament\Resources\CommunityActivities;

use App\Filament\Resources\CommunityActivities\Pages\ManageAdministrativeActivities;
use App\Filament\Resources\CommunityActivities\Pages\ManageCampaigns;
use App\Models\CommunityActivity;
use Filament\Resources\Resource;

class CommunityActivityResource extends Resource
{
    protected static ?string $model = CommunityActivity::class;

    protected static ?int $navigationSort = 2;

    protected static ?string $slug = 'community';

    public static function getModelLabel(): string
    {
        return __('community_activity.label.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('community_activity.label.plural');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageCampaigns::route('/'),
            'administrative' => ManageAdministrativeActivities::route('/administrative'),
        ];
    }
}
