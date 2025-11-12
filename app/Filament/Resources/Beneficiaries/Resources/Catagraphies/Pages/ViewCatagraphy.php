<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Resources\Catagraphies\Pages;

use App\Filament\Resources\Beneficiaries\Concerns\UsesParentRecordSubNavigation;
use App\Filament\Resources\Beneficiaries\Resources\Catagraphies\CatagraphyResource;
use App\Filament\Resources\Beneficiaries\Resources\Catagraphies\Concerns\GetRecordFromParentRecord;
use App\Filament\Resources\Beneficiaries\Resources\Catagraphies\Concerns\HasBreadcrumbs;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCatagraphy extends ViewRecord
{
    use HasBreadcrumbs;
    use GetRecordFromParentRecord;
    use UsesParentRecordSubNavigation;

    protected static string $resource = CatagraphyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return __('catagraphy.form.view');
    }

    public function getBreadcrumb(): string
    {
        return $this->getTitle();
    }
}
