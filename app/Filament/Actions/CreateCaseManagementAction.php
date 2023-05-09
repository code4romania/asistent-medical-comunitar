<?php

declare(strict_types=1);

namespace App\Filament\Actions;

use App\Filament\Resources\InterventionResource;
use App\Models\Intervention\CaseManagement;
use Filament\Pages\Actions\CreateAction;

class CreateCaseManagementAction extends CreateAction
{
    public static function getDefaultName(): ?string
    {
        return 'create_case_management';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('intervention.action.open_case'));

        $this->modalHeading(__('intervention.action.open_case'));

        $this->icon('heroicon-o-folder-add');

        $this->disableCreateAnother();

        $this->model(CaseManagement::class);

        $this->using(function (array $data) {
            $data['beneficiary_id'] = $this->getRecord()?->id;
            $data['status'] = 'REPLACE_ME';

            return CaseManagement::create($data);
        });

        $this->form(InterventionResource::getCaseFormSchema());
    }
}
