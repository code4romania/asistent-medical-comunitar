<?php

declare(strict_types=1);

namespace App\Filament\Resources\CatagraphyResource\Concerns;

use App\Filament\Resources\BeneficiaryResource;

trait HasRecordBreadcrumb
{
    protected function getBreadcrumbs(): array
    {
        $beneficiary = $this->getRecord()->beneficiary;

        return [
            BeneficiaryResource::getUrl('index') => BeneficiaryResource::getBreadcrumb(),
            BeneficiaryResource::getUrl('view', $beneficiary) => $beneficiary->full_name ?? __('field.has_unknown_identity'),
            BeneficiaryResource::getUrl('catagraphy', $beneficiary) => __('beneficiary.section.catagraphy'),
            $this->getBreadcrumb(),
        ];
    }
}
