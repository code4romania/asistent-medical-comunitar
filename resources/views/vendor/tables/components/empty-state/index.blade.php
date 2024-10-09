@props([
    'actions' => null,
    'description' => null,
    'heading',
    'icon',
    'iconClass' => null,
])

<div
    {{ $attributes->class([
        'filament-tables-empty-state flex flex-1 flex-col items-center justify-center px-6 py-24 mx-auto space-y-6 text-center bg-white',
        'dark:bg-gray-800' => config('tables.dark_mode'),
    ]) }}>
    <div @class([
        'flex items-center justify-center w-28 h-28',
        $iconClass ? $iconClass : 'text-primary-500',
    ])>
        <x-dynamic-component
            :component="$icon"
            class="w-full h-full"
            wire:loading.remove.delay
            wire:target="{{ implode(',', \Filament\Tables\Table::LOADING_TARGETS) }}"
        />

        <x-filament-support::loading-indicator
            class="w-6 h-6"
            wire:loading.delay
            wire:target="{{ implode(',', \Filament\Tables\Table::LOADING_TARGETS) }}"
        />
    </div>

    <div class="max-w-sm space-y-1">
        <x-tables::empty-state.heading>
            {{ $heading }}
        </x-tables::empty-state.heading>

        @if ($description)
            <x-tables::empty-state.description>
                {{ $description }}
            </x-tables::empty-state.description>
        @endif
    </div>

    @if ($actions)
        <x-tables::actions
            :actions="$actions"
            alignment="center"
            wrap
        />
    @endif
</div>
