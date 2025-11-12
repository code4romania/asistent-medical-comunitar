<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Resources\Documents\Pages;

use App\Filament\Resources\Beneficiaries\Concerns\UsesParentRecordSubNavigation;
use App\Filament\Resources\Beneficiaries\Resources\Documents\Concerns\HasBreadcrumbs;
use App\Filament\Resources\Beneficiaries\Resources\Documents\DocumentResource;
use Filament\Resources\Pages\ViewRecord;

class ViewDocument extends ViewRecord
{
    use HasBreadcrumbs;
    use UsesParentRecordSubNavigation;

    protected static string $resource = DocumentResource::class;

    public function getTitle(): string
    {
        return $this->getRecordTitle();
    }

    public function getBreadcrumb(): string
    {
        return $this->getTitle();
    }
}
