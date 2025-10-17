<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Resources\Interventions\Concerns;

use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use App\Filament\Resources\Beneficiaries\Pages\ListInterventions;
use App\Filament\Resources\Beneficiaries\Resources\Interventions\InterventionResource;
use App\Filament\Resources\Beneficiaries\Resources\Interventions\Pages\EditIntervention;
use App\Models\Beneficiary;
use App\Models\Intervention;

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

        if (! $this instanceof ListInterventions) {
            $breadcrumbs[BeneficiaryResource::getUrl('interventions', $parameters)] = ListInterventions::getNavigationLabel();
        }

        if ($this instanceof EditIntervention) {
            /** @var Intervention */
            $intervention = $this->getRecord();

            $parameters = [
                'beneficiary' => $beneficiary,
                'record' => $intervention,
            ];

            $breadcrumbs[InterventionResource::geturl('view', $parameters)] = InterventionResource::getRecordTitle($intervention);
        }

        $breadcrumbs[] = $this->getBreadcrumb();

        return $breadcrumbs;
    }
}
