<?php

declare(strict_types=1);

namespace App\Filament\Resources\CommunityActivities\Pages;

use App\Contracts\Pages\WithTabs;
use App\Filament\Resources\CommunityActivities\CommunityActivityResource;
use App\Filament\Resources\CommunityActivities\Concerns\HasActions;
use App\Filament\Resources\CommunityActivities\Concerns\HasTabs;
use App\Filament\Resources\CommunityActivities\Tables\CampaignsTable;
use Filament\Resources\Pages\ManageRecords;
use Filament\Tables\Table;

class ManageCampaigns extends ManageRecords implements WithTabs
{
    use HasActions;
    use HasTabs;

    protected static string $resource = CommunityActivityResource::class;

    public function table(Table $table): Table
    {
        return CampaignsTable::configure($table);
    }
}
