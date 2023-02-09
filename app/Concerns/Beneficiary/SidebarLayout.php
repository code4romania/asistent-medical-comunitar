<?php

declare(strict_types=1);

namespace App\Concerns\Beneficiary;

use App\Contracts\Pages\WithSidebar;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;

trait SidebarLayout
{
    public function bootedSidebarLayout(): void
    {
        if (! $this instanceof WithSidebar) {
            return;
        }

        // Sidebar layout doesn't apply to ocasional beneficiaries
        if ($this->getRecord()->isOcasional()) {
            return;
        }

        static::$layout = 'components.layouts.app-with-sidebar';
    }

    public function getSidebarNavigation(): array
    {
        $record = static::getRecord();

        return [
            NavigationGroup::make()
                ->items([
                    NavigationItem::make()
                        ->label('Overview')
                        ->icon('heroicon-o-home')
                        ->url(static::getResource()::getUrl('view', $record))
                        ->isActiveWhen(fn (): bool => request()->routeIs('filament.resources.beneficiaries.view')),

                    NavigationItem::make()
                        ->label('Date personale')
                        ->icon('heroicon-o-home')
                        ->url(static::getResource()::getUrl('personal_data.view', $record))
                        ->isActiveWhen(fn (): bool => request()->routeIs('filament.resources.beneficiaries.personal_data.*')),
                ]),
        ];
    }

    protected function getLayoutData(): array
    {
        return array_merge(parent::getLayoutData(), [
            'navigation' => $this->getSidebarNavigation(),
        ]);
    }
}
