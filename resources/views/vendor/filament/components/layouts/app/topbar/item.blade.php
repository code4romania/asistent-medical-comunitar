@props([
    'active' => false,
    'badge' => null,
    'badgeColor' => null,
    'shouldOpenUrlInNewTab' => false,
    'url',
])

<li @class([
    'filament-sidebar-item overflow-hidden',
    'block w-full md:inline-flex md:w-auto',
    'filament-sidebar-item-active' => $active,
])>
    <a
        href="{{ $url }}"
        {!! $shouldOpenUrlInNewTab ? 'target="_blank"' : '' !!}
        @class([
            'flex items-center justify-center gap-3 px-3 py-2 rounded-md md:text-sm transition',
            'hover:bg-gray-500/5 focus:bg-gray-500/5' => !$active,
            'dark:text-gray-300 dark:hover:bg-gray-700' =>
                !$active && config('filament.dark_mode'),
            'bg-white text-primary-900' => $active,
        ])>

        <div class="flex flex-1">
            <span>
                {{ $slot }}
            </span>
        </div>
    </a>
</li>
