<x-filament::page
    :widget-data="['record' => $record]"
    :class="\Illuminate\Support\Arr::toCssClasses([
        'filament-resources-edit-record-page',
        'filament-resources-' . str_replace('/', '-', $this->getResource()::getSlug()),
        'filament-resources-record-' . $record->getKey(),
        'pb-20',
    ])"
>
    @capture($form)
        <x-filament::form wire:submit.prevent="save">
            {{ $this->form }}

            <div class="fixed inset-x-0 bottom-0 p-6 bg-white border-t border-gray-300">
                <x-filament::form.actions
                    :actions="$this->getCachedFormActions()"
                    :full-width="$this->hasFullWidthFormActions()"
                />
            </div>
        </x-filament::form>
    @endcapture

    @php
        $relationManagers = $this->getRelationManagers();
    @endphp

    @if (!$this->hasCombinedRelationManagerTabsWithForm() || !count($relationManagers))
        {{ $form() }}
    @endif

    @if (count($relationManagers))
        @if (!$this->hasCombinedRelationManagerTabsWithForm())
            <x-filament::hr />
        @endif

        <x-filament::resources.relation-managers
            :active-manager="$activeRelationManager"
            :form-tab-label="$this->getFormTabLabel()"
            :managers="$relationManagers"
            :owner-record="$record"
            :page-class="static::class"
        >
            @if ($this->hasCombinedRelationManagerTabsWithForm())
                <x-slot name="form">
                    {{ $form() }}
                </x-slot>
            @endif
        </x-filament::resources.relation-managers>
    @endif
</x-filament::page>
