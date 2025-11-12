<?php

declare(strict_types=1);

namespace App\Filament\Resources\Households\Pages;

use App\Contracts\Pages\WithTabs;
use App\Filament\Resources\Beneficiaries\Concerns\HasBreadcrumbs;
use App\Filament\Resources\Beneficiaries\Concerns\HasTabs;
use App\Filament\Resources\Households\HouseholdResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageHouseholds extends ManageRecords implements WithTabs
{
    use HasBreadcrumbs;
    use HasTabs;

    protected static string $resource = HouseholdResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
