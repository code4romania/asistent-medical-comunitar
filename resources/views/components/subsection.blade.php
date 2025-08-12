@props([
    'icon' => null,
    'heading' => null,
])

<div {{ $attributes->class('grid gap-3') }}>

    @if ($heading)
        <x-filament::section.heading>
            {{ $heading }}
        </x-filament::section.heading>
    @endif

    <div
        @class([
            'flex flex-col items-stretch min-h-full rounded-xl overflow-hidden sm:flex-row',
            'shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10',
            'bg-gray-50 dark:bg-gray-800',
        ])>
        <div @class(['p-3 sm:pt-6 shrink-0', 'bg-gray-200 dark:bg-gray-700'])>
            @if ($icon)
                <x-dynamic-component :component="$icon" class="w-6 h-6" />
            @else
                <div class="w-6 h-6"></div>
            @endif
        </div>

        <div class="flex-1 p-3 sm:p-6">
            {{ $slot }}
        </div>
    </div>
</div>
