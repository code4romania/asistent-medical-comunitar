<?php

declare(strict_types=1);

namespace App\Filament\Actions;

use App\Filament\Resources\InterventionResource;
use App\Models\Intervention\IndividualService;
use Filament\Pages\Actions\CreateAction;

class CreateIndividualServiceAction extends CreateAction
{
    public static function getDefaultName(): ?string
    {
        return 'create_individual_service';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('intervention.action.add_service'));

        $this->modalHeading(__('intervention.action.add_service'));

        $this->icon('heroicon-o-plus-circle');

        $this->disableCreateAnother();

        $this->model(IndividualService::class);

        $this->using(function (array $data) {
            $data['beneficiary_id'] = $this->getRecord()?->id;
            $data['status'] = 'REPLACE_ME';

            return IndividualService::create($data);
        });

        $this->form(InterventionResource::getIndividualServiceFormSchema());
    }
}
