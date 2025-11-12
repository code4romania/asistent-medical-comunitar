<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Pages;

use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use App\Filament\Resources\Beneficiaries\Schemas\OcasionalBeneficiaryForm;
use App\Filament\Resources\Beneficiaries\Schemas\RegularBeneficiaryForm;
use App\Models\Beneficiary;
use Filament\Resources\Pages\EditRecord;
use Filament\Schemas\Schema;

class EditBeneficiary extends EditRecord
{
    protected static string $resource = BeneficiaryResource::class;

    public function form(Schema $schema): Schema
    {
        /** @var Beneficiary */
        $beneficiary = $this->getRecord();

        if ($beneficiary->isRegular()) {
            return RegularBeneficiaryForm::configure($schema, includeProgram:true);
        }

        return OcasionalBeneficiaryForm::configure($schema);
    }
}
