<?php

declare(strict_types=1);

namespace App\Filament\Resources\ReportResource\Pages;

use App\Contracts\Pages\WithTabs;
use App\Filament\Resources\ReportResource;
use App\Filament\Resources\ReportResource\Concerns;
use Filament\Resources\Pages\ListRecords;

class ListReports extends ListRecords implements WithTabs
{
    use Concerns\HasTabs;

    protected static string $resource = ReportResource::class;

    protected function getActions(): array
    {
        return [];
    }
}
