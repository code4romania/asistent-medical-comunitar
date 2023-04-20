<?php

declare(strict_types=1);

namespace App\Filament\Resources\BeneficiaryResource\Pages;

use App\Contracts\Pages\WithSidebar;
use App\Filament\Resources\BeneficiaryResource;
use App\Filament\Resources\BeneficiaryResource\Concerns;
use App\Filament\Resources\BeneficiaryResource\RelationManagers\HistoryRelationManager;
use Filament\Resources\Pages\ViewRecord;

class ListHistory extends ViewRecord implements WithSidebar
{
    use Concerns\FiltersRelationManagers;
    use Concerns\HasActions;
    use Concerns\HasRecordBreadcrumb;
    use Concerns\HasSidebar;

    protected static string $view = 'filament.pages.relation-managers';

    protected static string $resource = BeneficiaryResource::class;

    public function getTitle(): string
    {
        return __('activity.label');
    }

    public function getBreadcrumb(): string
    {
        return $this->getTitle();
    }

    protected function getActions(): array
    {
        return [];
    }

    protected function getAllowedRelationManager(): ?string
    {
        return HistoryRelationManager::class;
    }
}
