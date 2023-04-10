<x-filament::page :class="\Illuminate\Support\Arr::toCssClasses([
    'filament-resources-create-record-page',
    'filament-resources-' . str_replace('/', '-', $this->getResource()::getSlug()),
    'pb-20',
])">
    <x-filament::form wire:submit.prevent="create">
        {{ $this->form }}

        <div @class([
            'fixed inset-x-0 bottom-0 p-6 bg-white border-t border-gray-300' =>
                $this instanceof \App\Contracts\Forms\FixedActionBar,
        ])>
            <x-filament::form.actions
                :actions="$this->getCachedFormActions()"
                :full-width="$this->hasFullWidthFormActions()"
            />
        </div>
    </x-filament::form>
</x-filament::page>
