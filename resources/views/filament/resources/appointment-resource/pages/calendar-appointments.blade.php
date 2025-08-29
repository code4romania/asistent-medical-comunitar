<x-filament-panels::page
    @class([
        'fi-resource-list-records-page',
        'fi-resource-' . str_replace('/', '-', $this->getResource()::getSlug()),
    ])>

    <div class="flex flex-col gap-y-6">
        <x-tabs :tabs="$this->getTabsNavigation()">
            {{-- {{ $this->table }} --}}
        </x-tabs>
    </div>
</x-filament-panels::page>
