@props([
    'size' => null,
    'color' => null,
])

<span
    {{ $attributes->class([
        'inline-flex items-center text-xs font-medium tracking-tight rounded-full gap-x-1 whitespace-nowrap',
        match ($size) {
            'sm' => 'px-1.5 py-0.5',
            null => 'px-2 py-1',
            default => $size,
        },
        match ($color) {
            'danger' => 'text-danger-800 bg-danger-100',
            'primary' => 'text-primary-800 bg-primary-100',
            'success' => 'text-success-800 bg-success-100',
            'warning' => 'text-warning-800 bg-warning-100',
            null, 'secondary' => 'text-gray-800 bg-gray-100',
            default => $color,
        },
    ]) }}
>
    <x-icon-badge-dot class="h-1.5 w-1.5 shrink-0 opacity-70" />

    {{ $slot }}
</span>
