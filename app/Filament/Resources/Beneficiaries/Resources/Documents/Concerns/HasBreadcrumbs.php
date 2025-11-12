<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Resources\Documents\Concerns;

use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use App\Filament\Resources\Beneficiaries\Pages\ListDocuments;
use App\Filament\Resources\Beneficiaries\Resources\Documents\DocumentResource;
use App\Filament\Resources\Beneficiaries\Resources\Documents\Pages\EditDocument;
use App\Models\Beneficiary;
use App\Models\Document;

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

        if (! $this instanceof ListDocuments) {
            $breadcrumbs[BeneficiaryResource::getUrl('documents', $parameters)] = ListDocuments::getNavigationLabel();
        }

        if ($this instanceof EditDocument) {
            /** @var Document */
            $document = $this->getRecord();

            $parameters = [
                'beneficiary' => $beneficiary,
                'record' => $document,
            ];

            $breadcrumbs[DocumentResource::geturl('view', $parameters)] = DocumentResource::getRecordTitle($document);
        }

        $breadcrumbs[] = $this->getBreadcrumb();

        return $breadcrumbs;
    }
}
