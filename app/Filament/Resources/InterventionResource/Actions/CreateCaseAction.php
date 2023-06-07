<?php

declare(strict_types=1);

namespace App\Filament\Resources\InterventionResource\Actions;

use App\Filament\Resources\InterventionResource;
use App\Models\Intervention\InterventionableCase;
use Filament\Pages\Actions\CreateAction;

class CreateCaseAction extends CreateAction
{
    public static function getDefaultName(): ?string
    {
        return 'create_case';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('intervention.action.open_case'));

        $this->modalHeading(__('intervention.action.open_case'));

        $this->icon('heroicon-o-folder-add');

        $this->disableCreateAnother();

        $this->model(InterventionableCase::class);

        $this->using(function (array $data) {
            $data['beneficiary_id'] = $this->getRecord()?->id;

            return InterventionableCase::create($data);
        });

        $this->form(InterventionResource::getCaseFormSchema());
    }
}
