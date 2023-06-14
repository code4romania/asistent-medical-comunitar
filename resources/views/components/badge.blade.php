@props([
    'size' => null,
    'color' => null,
])

<span
    {{ $attributes->class([
        'inline-flex items-center font-medium tracking-tight rounded-full whitespace-nowrap',
        match ($size) {
            'sm' => 'px-2.5 py-0.5 text-xs',
            null, 'lg' => 'px-3 py-0.5 text-sm',
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
    <x-icon-badge-dot @class([
        'mr-0.5 h-4 w-4 shrink-0',
        match ($size) {
            'sm' => '-ml-1.5',
            default => '-ml-2',
        },
    ]) />

    {{ $slot }}
</span>
