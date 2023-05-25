<?php

declare(strict_types=1);

namespace App\Filament\Resources\ReportResource\Pages;

use App\Contracts\Pages\WithTabs;
use App\Filament\Resources\ReportResource;
use App\Filament\Resources\ReportResource\Concerns;
use Filament\Resources\Pages\ViewRecord;

class ViewReport extends ViewRecord implements WithTabs
{
    use Concerns\HasTabs;

    protected static string $resource = ReportResource::class;

    protected static string $view = 'filament.resources.report-resource.pages.generate';

    protected function getActions(): array
    {
        return [];
    }
}
