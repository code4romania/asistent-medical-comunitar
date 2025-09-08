<?php

declare(strict_types=1);

namespace App\Filament\Resources\Catagraphies\Pages;

use App\Filament\Resources\Catagraphies\CatagraphyResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCatagraphy extends CreateRecord
{
    protected static string $resource = CatagraphyResource::class;

    public function getBreadcrumbs(): array
    {
        return [];
    }
}
