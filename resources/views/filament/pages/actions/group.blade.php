@php
    $actions = $getActions();
    $color = $getColor();
    $darkMode = config('filament.dark_mode');
    $icon = $getIcon() ?? 'heroicon-o-dots-vertical';
    $label = $getLabel() ?? __('filament-actions::group.trigger.label');
    $size = $getSize();
    $tooltip = $getTooltip();
@endphp

<x-filament-support::dropdown
    :dark-mode="$darkMode"
    placement="bottom-end"
    teleport
    {{ $attributes }}>
    <x-slot name="trigger">
        <x-filament-support::button
            :color="$color"
            :dark-mode="$darkMode"
            :icon="$icon"
            :size="$size"
            :tooltip="$tooltip"
            icon-position="after">
            {{ $label }}
        </x-filament-support::button>
    </x-slot>

    <x-filament-support::dropdown.list>
        @foreach ($actions as $action)
            @if (!$action->isHidden())
                {{ $action }}
            @endif
        @endforeach
    </x-filament-support::dropdown.list>
</x-filament-support::dropdown>
