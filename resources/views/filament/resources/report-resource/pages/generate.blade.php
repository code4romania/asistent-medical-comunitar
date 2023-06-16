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

    @if ($this->record)
        {{ $this->report }}
    @endif
</x-filament::page>
