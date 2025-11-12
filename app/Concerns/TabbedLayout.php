<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Contracts\Pages\WithTabs;
use App\Filament\Schemas\Components\Tabs;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\EditRecord;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Components\EmbeddedTable;
use Filament\Schemas\Components\RenderHook;
use Filament\Schemas\Schema;
use Filament\View\PanelsRenderHook;

trait TabbedLayout
{
    public function content(Schema $schema): Schema
    {
        if (! $this instanceof WithTabs) {
            return parent::content($schema);
        }

        $components = [
            Tabs::make()
                ->tabs($this->getTabsNavigation())
                ->contained(! $this instanceof ListRecords)
                ->components(function (Schema $schema): array {
                    if ($this instanceof ListRecords) {
                        return [
                            RenderHook::make(PanelsRenderHook::RESOURCE_PAGES_LIST_RECORDS_TABLE_BEFORE),
                            EmbeddedTable::make(),
                            RenderHook::make(PanelsRenderHook::RESOURCE_PAGES_LIST_RECORDS_TABLE_AFTER),
                        ];
                    }

                    if ($this instanceof ViewRecord) {
                        if ($this->hasInfolist()) {
                            return [$this->getInfolistContentComponent()];
                        }

                        return [$this->getFormContentComponent()];
                    }

                    if (
                        $this instanceof CreateRecord ||
                        $this instanceof EditRecord
                    ) {
                        return [$this->getFormContentComponent()];
                    }

                    return parent::content($schema);
                }),
        ];

        if (method_exists($this, 'getRelationManagersContentComponent')) {
            $components[] = $this->getRelationManagersContentComponent();
        }

        return $schema
            ->components($components);
    }
}
