<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Pages;

use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use App\Filament\Resources\Beneficiaries\Resources\Documents\DocumentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Support\Icons\Heroicon;

class ListDocuments extends ManageRelatedRecords
{
    protected static string $resource = BeneficiaryResource::class;

    protected static string $relationship = 'documents';

    protected static ?string $relatedResource = DocumentResource::class;

    public function getTitle(): string
    {
        return __('beneficiary.section.documents');
    }

    public function getBreadcrumb(): string
    {
        return $this->getTitle();
    }

    public static function getNavigationLabel(): string
    {
        return __('beneficiary.section.documents');
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label(__('document.action.create'))
                ->modalHeading(__('document.action.create'))
                ->icon(Heroicon::OutlinedPlusCircle)
                ->createAnother(false)
                ->mutateDataUsing(function (array $data) {
                    $data['beneficiary_id'] = $this->getRecord()->id;

                    return $data;
                }),
        ];
    }
}
