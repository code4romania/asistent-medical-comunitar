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

    <x-filament::resources.relation-managers
        :active-manager="$activeRelationManager"
        :form-tab-label="$this->getFormTabLabel()"
        :managers="$relationManagers"
        :owner-record="$record"
        :page-class="static::class"
    />

</x-filament::page>
