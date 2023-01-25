<x-filament::page :class="\Illuminate\Support\Arr::toCssClasses([
    'filament-resources-list-records-page',
    'filament-resources-' . str_replace('/', '-', $this->getResource()::getSlug()),
])">

    <x-tabs
        :tabs="$this->getTabs()"
        :active-tab="$this->getActiveTab()"
        label-prefix="beneficiary.section"
    >
        {{ $this->table }}
    </x-tabs>

</x-filament::page>
