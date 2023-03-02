<?php

declare(strict_types=1);

namespace App\Filament\Resources\BeneficiaryResource\Concerns;

use App\Filament\Resources\BeneficiaryResource\Pages\OverviewBeneficiary;
use Filament\Resources\Pages\ListRecords;

trait HasRecordBreadcrumb
{
    protected function getBreadcrumbs(): array
    {
        if ($this instanceof ListRecords) {
            return [];
        }

        $resource = static::getResource();

        $breadcrumbs = [
            $resource::getUrl() => $resource::getBreadcrumb(),
        ];

        if (! $this instanceof OverviewBeneficiary) {
            if ($this->getRecord()->exists && $resource::hasRecordTitle()) {
                if ($resource::hasPage('view') && $resource::canView($this->getRecord())) {
                    $breadcrumbs[
                        $resource::getUrl('view', ['record' => $this->getRecord()])
                    ] = $this->getRecordTitle();
                } elseif ($resource::hasPage('edit') && $resource::canEdit($this->getRecord())) {
                    $breadcrumbs[
                        $resource::getUrl('edit', ['record' => $this->getRecord()])
                    ] = $this->getRecordTitle();
                } else {
                    $breadcrumbs[] = $this->getRecordTitle();
                }
            }
        }

        $breadcrumbs[] = $this->getBreadcrumb();

        return $breadcrumbs;
    }
}
