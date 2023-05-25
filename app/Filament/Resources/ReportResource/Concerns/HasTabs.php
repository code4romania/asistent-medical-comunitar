<?php

declare(strict_types=1);

namespace App\Filament\Resources\ReportResource\Concerns;

use App\Concerns\TabbedLayout;
use App\Filament\Resources\ReportResource\Pages;
use Filament\Navigation\NavigationItem;

trait HasTabs
{
    use TabbedLayout;

    public function getTabs(): array
    {
        return [

            NavigationItem::make()
                ->label(__('report.section.generator'))
                ->icon('icon-none')
                ->url(static::getResource()::getUrl('index'))
                ->isActiveWhen(fn (): bool => static::class === Pages\GenerateReport::class),

            NavigationItem::make()
                ->label(__('report.section.list'))
                ->icon('icon-none')
                ->url(static::getResource()::getUrl('saved'))
                ->isActiveWhen(fn (): bool => static::class === Pages\ListReports::class),

        ];
    }

    public function isTableSelectionEnabled(): bool
    {
        return false;
    }

    public function getHeading(): string
    {
        return __('report.header.list');
    }

    protected function getBreadcrumbs(): array
    {
        return [];
    }
}
