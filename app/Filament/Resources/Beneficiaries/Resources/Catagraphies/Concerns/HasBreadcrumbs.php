<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Resources\Catagraphies\Concerns;

use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use App\Filament\Resources\Beneficiaries\Resources\Catagraphies\CatagraphyResource;
use App\Filament\Resources\Beneficiaries\Resources\Catagraphies\Pages\SummaryCatagraphy;
use App\Models\Beneficiary;

trait HasBreadcrumbs
{
    public function getBreadcrumbs(): array
    {
        /** @var Beneficiary */
        $beneficiary = $this->getParentRecord();

        $parameters = [
            'record' => $beneficiary,
        ];

        $breadcrumbs = [
            BeneficiaryResource::getUrl('index') => BeneficiaryResource::getBreadcrumb(),
            BeneficiaryResource::getUrl('view', $parameters) => BeneficiaryResource::getRecordTitle($beneficiary),
        ];

        if (! $this instanceof SummaryCatagraphy) {
            $parameters = [
                'beneficiary' => $beneficiary,
            ];

            $breadcrumbs[CatagraphyResource::getUrl('index', $parameters)] = SummaryCatagraphy::getNavigationLabel();
        }

        $breadcrumbs[] = $this->getBreadcrumb();

        return $breadcrumbs;
    }
}
