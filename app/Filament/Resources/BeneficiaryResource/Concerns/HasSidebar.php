<?php

declare(strict_types=1);

namespace App\Filament\Resources\BeneficiaryResource\Concerns;

use App\Contracts\Pages\WithSidebar;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;

trait HasSidebar
{
    public function bootedHasSidebar(): void
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
                        ->icon('icon-none')
                        ->url(static::getResource()::getUrl('view', $record))
                        ->isActiveWhen(fn (): bool => request()->routeIs('filament.resources.beneficiaries.view')),

                    NavigationItem::make()
                        ->label(__('beneficiary.section.personal_data'))
                        ->icon('icon-none')
                        ->url(static::getResource()::getUrl('personal_data', $record))
                        ->isActiveWhen(fn (): bool => request()->routeIs(
                            'filament.resources.beneficiaries.personal_data',
                            'filament.resources.beneficiaries.edit'
                        )),

                    NavigationItem::make()
                        ->label(__('beneficiary.section.catagraphy'))
                        ->icon('icon-none')
                        ->url(static::getResource()::getUrl('catagraphy', $record))
                        ->isActiveWhen(fn (): bool => request()->routeIs('filament.resources.beneficiaries.catagraphy')),

                    NavigationItem::make()
                        ->label(__('intervention.label.plural'))
                        ->icon('icon-none')
                        ->url(static::getResource()::getUrl('interventions', $record))
                        ->isActiveWhen(fn (): bool => request()->routeIs('filament.resources.beneficiaries.interventions')),

                    NavigationItem::make()
                        ->label(__('activity.label'))
                        ->icon('icon-none')
                        ->url(static::getResource()::getUrl('history', $record))
                        ->isActiveWhen(fn (): bool => request()->routeIs('filament.resources.beneficiaries.history')),
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
