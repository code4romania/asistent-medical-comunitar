<?php

declare(strict_types=1);

namespace App\Filament\Resources\Interventions\Concerns;

use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use App\Filament\Resources\Interventions\Pages\ListInterventions;
use App\Models\Beneficiary;

trait HasRecordBreadcrumb
{
    public function getBreadcrumbs(): array
    {
        /** @var Beneficiary */
        $beneficiary = $this->getBeneficiary();

        $breadcrumbs = [
            BeneficiaryResource::getUrl('index') => BeneficiaryResource::getBreadcrumb(),
            BeneficiaryResource::getUrl('view', $beneficiary) => $beneficiary->full_name ?? __('field.has_unknown_identity'),
        ];

        if (! $this instanceof ListInterventions) {
            $breadcrumbs[
                BeneficiaryResource::getUrl('interventions.index', $beneficiary)
            ] = __('intervention.label.plural');
        }

        $breadcrumbs[] = $this->getBreadcrumb();

        return $breadcrumbs;
    }
}
