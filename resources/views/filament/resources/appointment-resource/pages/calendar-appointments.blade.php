<x-filament-panels::page
    @class([
        'fi-resource-list-records-page',
        'fi-resource-' . str_replace('/', '-', $this->getResource()::getSlug()),
    ])>

    <div class="flex flex-col gap-y-6">
        <x-tabs :tabs="$this->getTabsNavigation()">
            @if ($headerWidgets = $this->getHeaderWidgets())
                <x-filament-widgets::widgets
                    :columns="$this->getHeaderWidgetsColumns()"
                    :data="$this->getWidgetData()"
                    :widgets="$headerWidgets"
                    class="fi-page-header-widgets" />
            @endif
        </x-tabs>
    </div>
</x-filament-panels::page>
