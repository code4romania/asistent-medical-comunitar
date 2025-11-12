<?php

declare(strict_types=1);

namespace App\Filament\Resources\CommunityActivities\Actions;

use App\Enums\CommunityActivity\Type;
use App\Filament\Resources\CommunityActivities\Schemas\AdministrativeActivityForm;
use App\Models\CommunityActivity;
use Filament\Actions\CreateAction;
use Filament\Schemas\Schema;

class CreateAdministrativeActivityAction extends CreateAction
{
    public static function getDefaultName(): ?string
    {
        return 'create_administrative_activity';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('community_activity.action.create_administrative'));
        $this->modalHeading(__('community_activity.action.create_administrative'));

        $this->groupedIcon(null);
        $this->createAnother(false);

        $this->using(function (array $data) {
            $data['type'] = Type::ADMINISTRATIVE;

            return CommunityActivity::create($data);
        });

        $this->schema(fn (Schema $schema) => AdministrativeActivityForm::configure($schema));
    }
}
