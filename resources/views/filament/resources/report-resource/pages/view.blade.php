<x-filament::page>
    <x-tabs :tabs="$this->getTabs()">
        <x-filament::form wire:submit.prevent="generate">
            {{ $this->form }}

            <x-filament::form.actions
                :actions="$this->getCachedFormActions()"
                :full-width="$this->hasFullWidthFormActions()"
            />
        </x-filament::form>
    </x-tabs>

    <x-reports.table :record="$this->getRecord()" />
</x-filament::page>
