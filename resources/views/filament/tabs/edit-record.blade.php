<x-filament::page
    :widget-data="['record' => $record]"
    :class="\Illuminate\Support\Arr::toCssClasses([
        'filament-resources-edit-record-page',
        'filament-resources-' . str_replace('/', '-', $this->getResource()::getSlug()),
        'filament-resources-record-' . $record->getKey(),
    ])"
>
    @php
        $relationManagers = $this->getRelationManagers();
    @endphp

    <x-tabs :tabs="$this->getTabs()">
        <x-filament::form wire:submit.prevent="save">
            {{ $this->form }}

            <x-filament::form.actions
                :actions="$this->getCachedFormActions()"
                :full-width="$this->hasFullWidthFormActions()"
            />
        </x-filament::form>
    </x-tabs>

    @if (count($relationManagers))
        <x-filament::hr />

        <x-filament::resources.relation-managers
            :active-manager="$activeRelationManager"
            :form-tab-label="$this->getFormTabLabel()"
            :managers="$relationManagers"
            :owner-record="$record"
            :page-class="static::class"
        />
    @endif
</x-filament::page>
