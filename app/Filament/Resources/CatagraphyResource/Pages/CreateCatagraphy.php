<?php

declare(strict_types=1);

namespace App\Filament\Resources\CatagraphyResource\Pages;

use App\Filament\Resources\CatagraphyResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCatagraphy extends CreateRecord
{
    protected static string $resource = CatagraphyResource::class;

    public function getBreadcrumbs(): array
    {
        return [];
    }
}
