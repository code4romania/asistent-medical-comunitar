<?php

declare(strict_types=1);

namespace App\Filament\Resources\BeneficiaryResource\Pages;

use App\Contracts\Pages\WithTabs;
use App\Filament\Resources\BeneficiaryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBeneficiaries extends ListRecords implements WithTabs
{
    protected static string $view = 'filament.pages.beneficiaries.list-records';

    protected static string $resource = BeneficiaryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function isTableSelectionEnabled(): bool
    {
        return false;
    }

    public function getTabs(): array
    {
        return $this->getResource()::getListRecordsTabs();
    }

    public function getActiveTab(): string
    {
        return collect($this->getResource()::getPages())
            ->search(fn (array $item) => $item['class'] === static::class);
    }

    public function getHeading(): string
    {
        return __('beneficiary.header.list');
    }

    protected function getBreadcrumbs(): array
    {
        return [];
    }
}
