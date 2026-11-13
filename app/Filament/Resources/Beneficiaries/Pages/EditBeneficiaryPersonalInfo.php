<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Pages;

use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use App\Filament\Resources\Beneficiaries\Schemas\OcasionalBeneficiaryForm;
use App\Filament\Resources\Beneficiaries\Schemas\RegularBeneficiaryPersonalInfoForm;
use App\Models\Beneficiary;
use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Schema;

class EditBeneficiaryPersonalInfo extends EditRecord
{
    protected static string $resource = BeneficiaryResource::class;

    public function getHeading(): string
    {
        return __('filament-panels::resources/pages/edit-record.title', [
            'label' => BeneficiaryResource::getRecordTitleWithId($this->getRecord()),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        /** @var Beneficiary */
        $beneficiary = $this->getRecord();

        if ($beneficiary->isRegular()) {
            return RegularBeneficiaryPersonalInfoForm::configure($schema, includeProgram:true);
        }

        return OcasionalBeneficiaryForm::configure($schema);
    }
}
