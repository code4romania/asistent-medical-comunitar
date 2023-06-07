<x-filament::page>
    <x-tabs :tabs="$this->getTabs()">
        <x-filament::widgets :widgets="$this->calendar()" />
    </x-tabs>
</x-filament::page>
