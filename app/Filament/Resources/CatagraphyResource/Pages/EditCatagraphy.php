<?php

declare(strict_types=1);

namespace App\Filament\Resources\CatagraphyResource\Pages;

use App\Filament\Resources\CatagraphyResource;
use App\Filament\Resources\CatagraphyResource\Concerns\ResolvesRecord;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCatagraphy extends EditRecord
{
    use ResolvesRecord;

    protected static string $resource = CatagraphyResource::class;

    protected function getActions(): array
    {
        return [
            Actions\ViewAction::make(),
            // Actions\DeleteAction::make(),
        ];
    }

    protected function getBreadcrumbs(): array
    {
        return [];
    }
}
