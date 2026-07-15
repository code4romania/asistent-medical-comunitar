<?php

declare(strict_types=1);

namespace App\Filament\Resources\CommunityActivities\Actions;

use App\Enums\CommunityActivity\Type;
use App\Filament\Resources\CommunityActivities\Schemas\CampaignForm;
use App\Models\CommunityActivity;
use Filament\Actions\CreateAction;
use Filament\Schemas\Schema;

class CreateCampaignAction extends CreateAction
{
    public static function getDefaultName(): ?string
    {
        return 'create_campaign';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('community_activity.action.create_campaign'));
        $this->modalHeading(__('community_activity.action.create_campaign'));

        $this->groupedIcon(null);
        $this->createAnother(false);

        $this->using(function (array $data) {
            $data['type'] = Type::CAMPAIGN;

            return CommunityActivity::create($data);
        });

        $this->schema(fn (Schema $schema) => CampaignForm::configure($schema));
    }
}
