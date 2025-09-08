<?php

declare(strict_types=1);

namespace App\Filament\Resources\Reports\Concerns;

use App\Filament\Resources\Reports\Pages\GenerateStandardReport;
use App\Filament\Resources\ReportResource\Pages\ListReports;
use App\Filament\Resources\Reports\Pages\ViewReport;
use App\Concerns\TabbedLayout;
use App\Filament\Resources\ReportResource\Pages;
use Filament\Navigation\NavigationItem;

trait HasTabs
{
    use TabbedLayout;

    public function getTabsNavigation(): array
    {
        return [

            NavigationItem::make()
                ->label(__('report.section.standard'))
                ->icon('icon-none')
                ->url(static::getResource()::getUrl('index'))
                ->isActiveWhen(fn (): bool => static::class === GenerateStandardReport::class),

            // NavigationItem::make()
            //     ->label(__('report.section.generator'))
            //     ->icon('icon-none')
            //     ->url(static::getResource()::getUrl('generate'))
            //     ->isActiveWhen(fn (): bool => static::class === Pages\GenerateReport::class),

            NavigationItem::make()
                ->label(__('report.section.list'))
                ->icon('icon-none')
                ->url(static::getResource()::getUrl('saved'))
                ->isActiveWhen(fn (): bool => \in_array(static::class, [ListReports::class, ViewReport::class])),

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

    public function getBreadcrumbs(): array
    {
        return [];
    }
}
