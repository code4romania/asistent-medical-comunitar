<?php

declare(strict_types=1);

namespace App\Filament\Resources\ReportResource\Pages;

use App\Filament\Resources\ReportResource;
use Filament\Resources\Pages\Page;

class ComingSoon extends Page
{
    protected static string $resource = ReportResource::class;

    protected static string $view = 'filament.resources.report-resource.pages.coming-soon';

    protected function getBreadcrumbs(): array
    {
        return [];
    }

    public function getHeading(): string
    {
        return __('report.header.list');
    }

    public function getSubHeading(): string
    {
        return __('report.header.coming_soon');
    }
}
