<x-filament::page
    :widget-data="['record' => $record]"
    :class="\Illuminate\Support\Arr::toCssClasses([
        'filament-resources-view-record-page',
        'filament-resources-' . str_replace('/', '-', $this->getResource()::getSlug()),
        'filament-resources-record-' . $record->getKey(),
    ])"
>
    @php
        $relationManagers = $this->getRelationManagers();
    @endphp

    <x-tabs
        :tabs="$this->getTabs()"
        :active-tab="$this->getActiveTab()"
        label-prefix="user.profile.section"
    >
        <x-filament::pages.actions
            :actions="$this->getCachedActions()"
            alignment="right"
            class="mb-6"
        />

        {{ $this->form }}
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
