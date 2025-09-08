<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Pages;

use App\Filament\Resources\Beneficiaries\Concerns\HasRecordBreadcrumb;
use App\Filament\Resources\Beneficiaries\Concerns\HasTabs;
use Filament\Actions\CreateAction;
use Filament\Actions\Action;
use App\Concerns\HasConditionalTableEmptyState;
use App\Contracts\Pages\WithTabs;
use App\Filament\Resources\Beneficiaries\BeneficiaryResource;
use App\Filament\Resources\BeneficiaryResource\Concerns;
use Filament\Pages;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables;

class ListBeneficiaries extends ListRecords implements WithTabs
{
    use HasConditionalTableEmptyState;
    use HasRecordBreadcrumb;
    use HasTabs;

    protected static string $resource = BeneficiaryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    protected function getTableEmptyStateIcon(): ?string
    {
        if ($this->hasAlteredTableQuery()) {
            return null;
        }

        return 'icon-empty-state';
    }

    protected function getTableEmptyStateHeading(): ?string
    {
        if ($this->hasAlteredTableQuery()) {
            return null;
        }

        return __('beneficiary.empty.title');
    }

    protected function getTableEmptyStateDescription(): ?string
    {
        if ($this->hasAlteredTableQuery()) {
            return null;
        }

        return __('beneficiary.empty.description');
    }

    protected function getTableEmptyStateActions(): array
    {
        return [
            Action::make('create')
                ->label(__('beneficiary.empty.create'))
                ->url(static::getResource()::getUrl('create'))
                ->button()
                ->color('gray')
                ->hidden(fn () => $this->hasAlteredTableQuery()),
        ];
    }

    public function getRelationManagers(): array
    {
        return [];
    }
}
