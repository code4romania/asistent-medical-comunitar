<x-filament::page :class="\Illuminate\Support\Arr::toCssClasses([
    'filament-resources-create-record-page',
    'filament-resources-' . str_replace('/', '-', $this->getResource()::getSlug()),
])">
    <x-tabs :tabs="$this->getTabs()">
        <x-filament::form wire:submit.prevent="create">
            {{ $this->form }}

            <x-filament::form.actions
                :actions="$this->getCachedFormActions()"
                :full-width="$this->hasFullWidthFormActions()"
            />
        </x-filament::form>
    </x-tabs>
</x-filament::page>
