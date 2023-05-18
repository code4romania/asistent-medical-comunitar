<?php

declare(strict_types=1);

namespace App\Filament\Resources\InterventionResource\Concerns;

use App\Filament\Resources\BeneficiaryResource;
use App\Filament\Resources\InterventionResource\Pages\ListInterventions;
use App\Models\Beneficiary;

trait HasRecordBreadcrumb
{
    protected function getBreadcrumbs(): array
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
