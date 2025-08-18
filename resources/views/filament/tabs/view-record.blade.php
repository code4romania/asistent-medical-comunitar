<x-filament-panels::page
    :class="\Illuminate\Support\Arr::toCssClasses([
        'fi-resource-view-record-page',
        'fi-resource-' . str_replace('/', '-', $this->getResource()::getSlug()),
        'fi-resource-record-' . $record->getKey(),
    ])">

    @php
        $relationManagers = $this->getRelationManagers();
        $hasCombinedRelationManagerTabsWithContent = $this->hasCombinedRelationManagerTabsWithContent();
    @endphp

    <x-tabs :tabs="$this->getTabs()">
        @if (!$hasCombinedRelationManagerTabsWithContent || !count($relationManagers))
            @if ($this->hasInfolist())
                {{ $this->infolist }}
            @else
                <div
                    wire:key="{{ $this->getId() }}.forms.{{ $this->getFormStatePath() }}">
                    {{ $this->form }}
                </div>
            @endif
        @endif
    </x-tabs>

    @if (count($relationManagers))
        <x-filament-panels::resources.relation-managers
            :active-locale="isset($activeLocale) ? $activeLocale : null"
            :active-manager="$this->activeRelationManager ??
                ($hasCombinedRelationManagerTabsWithContent ? null : array_key_first($relationManagers))"
            :content-tab-label="$this->getContentTabLabel()"
            :content-tab-icon="$this->getContentTabIcon()"
            :content-tab-position="$this->getContentTabPosition()"
            :managers="$relationManagers"
            :owner-record="$record"
            :page-class="static::class">
            @if ($hasCombinedRelationManagerTabsWithContent)
                <x-slot name="content">
                    @if ($this->hasInfolist())
                        {{ $this->infolist }}
                    @else
                        {{ $this->form }}
                    @endif
                </x-slot>
            @endif
        </x-filament-panels::resources.relation-managers>
    @endif

</x-filament-panels::page>
