<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Resources\Catagraphies\Pages;

use App\Filament\Resources\Beneficiaries\Concerns\UsesParentRecordSubNavigation;
use App\Filament\Resources\Beneficiaries\Resources\Catagraphies\CatagraphyResource;
use App\Filament\Resources\Beneficiaries\Resources\Catagraphies\Concerns\GetRecordFromParentRecord;
use App\Filament\Resources\Beneficiaries\Resources\Catagraphies\Concerns\HasBreadcrumbs;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditCatagraphy extends EditRecord
{
    use HasBreadcrumbs;
    use GetRecordFromParentRecord;
    use UsesParentRecordSubNavigation;

    protected static string $resource = CatagraphyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
