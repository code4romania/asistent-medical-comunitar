<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Pages;

use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use App\Filament\Resources\Beneficiaries\Schemas\OcasionalBeneficiaryForm;
use App\Filament\Resources\Beneficiaries\Schemas\RegularBeneficiaryProgramForm;
use App\Filament\Resources\Users\UserResource;
use App\Models\Beneficiary;
use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Schema;

class EditBeneficiaryProgram extends EditRecord
{
    protected static string $resource = BeneficiaryResource::class;

    protected function authorizeAccess(): void
    {
        parent::authorizeAccess();

        /** @var Beneficiary */
        $beneficiary = $this->getRecord();

        if ($beneficiary->isOcasional()) {
            redirect()->to(BeneficiaryResource::getUrl('edit', [
                'record' => $beneficiary,
            ]));
        }
    }

    public function getBreadcrumb(): string
    {
        return __('beneficiary.form.edit_program');
    }

    public function getHeading(): string
    {
        return __('filament-panels::resources/pages/edit-record.title', [
            'label' => BeneficiaryResource::getRecordTitleWithId($this->getRecord()),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return RegularBeneficiaryProgramForm::configure($schema);
    }
}
