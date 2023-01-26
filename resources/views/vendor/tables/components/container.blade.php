<div
    {{ $attributes->class([
        'dark:bg-gray-800' => config('tables.dark_mode'),
        'bg-white filament-tables-container',
    ]) }}>
    {{ $slot }}
</div>
