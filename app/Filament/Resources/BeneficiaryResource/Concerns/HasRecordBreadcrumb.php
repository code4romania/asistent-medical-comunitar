<?php

declare(strict_types=1);

namespace App\Filament\Resources\BeneficiaryResource\Concerns;

use App\Concerns\InteractsWithBeneficiary;
use App\Filament\Resources\BeneficiaryResource\Pages\OverviewBeneficiary;
use Filament\Resources\Pages\ListRecords;

trait HasRecordBreadcrumb
{
    use InteractsWithBeneficiary;

    protected function getBreadcrumbs(): array
    {
        if ($this instanceof ListRecords) {
            return [];
        }

        $resource = static::getResource();

        $beneficiary = $this->getBeneficiary();

        $breadcrumbs = [
            $resource::getUrl() => $resource::getBreadcrumb(),
        ];

        if (! $this instanceof OverviewBeneficiary) {
            if ($this->getBeneficiary()->exists && $resource::hasRecordTitle()) {
                if ($resource::hasPage('view') && $resource::canView($beneficiary)) {
                    $breadcrumbs[
                        $resource::getUrl('view', ['record' => $beneficiary])
                    ] = $resource::getRecordTitle($beneficiary);
                } elseif ($resource::hasPage('edit') && $resource::canEdit($beneficiary)) {
                    $breadcrumbs[
                        $resource::getUrl('edit', ['record' => $beneficiary])
                    ] = $resource::getRecordTitle($beneficiary);
                } else {
                    $breadcrumbs[] = $resource::getRecordTitle($beneficiary);
                }
            }
        }

        $breadcrumbs[] = $this->getBreadcrumb();

        return $breadcrumbs;
    }
}
