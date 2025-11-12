<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Concerns;

use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use App\Filament\Resources\Beneficiaries\Pages\EditBeneficiary;
use App\Filament\Resources\Beneficiaries\Pages\ViewBeneficiary;
use App\Models\Beneficiary;
use Filament\Resources\Pages\ListRecords;

trait HasBreadcrumbs
{
    public function getBreadcrumbs(): array
    {
        // No breadcrumbs for the list page
        if ($this instanceof ListRecords) {
            return [];
        }

        /** @var Beneficiary */
        $beneficiary = $this->getParentRecord() ?? $this->getRecord();

        $breadcrumbs = [
            BeneficiaryResource::getUrl('index') => BeneficiaryResource::getBreadcrumb(),
        ];

        if (
            ! $this instanceof ViewBeneficiary &&
            ! $this instanceof EditBeneficiary &&
            $beneficiary?->exists
        ) {
            $breadcrumbs[
                BeneficiaryResource::getUrl('view', ['record' => $beneficiary])
            ] = BeneficiaryResource::getRecordTitle($beneficiary);
        }

        $breadcrumbs[] = $this->getBreadcrumb();

        return $breadcrumbs;
    }
}
