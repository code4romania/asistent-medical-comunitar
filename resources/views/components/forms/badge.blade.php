<span
    {{ $attributes->class([
        'inline-flex items-center rounded-full font-medium',
        match ($getSize()) {
            'sm' => 'px-2.5 py-0.5 text-xs',
            null, 'lg' => 'px-3 py-0.5 text-sm',
            default => $getSize(),
        },
        match ($getColor()) {
            'danger' => 'text-danger-800 bg-danger-100',
            'primary' => 'text-primary-800 bg-primary-100',
            'success' => 'text-success-800 bg-success-100',
            'warning' => 'text-warning-800 bg-warning-100',
            null, 'secondary' => 'text-gray-800 bg-gray-100',
            default => $getColor(),
        },
    ]) }}
>
    <x-icon-badge-dot @class([
        'mr-0.5 h-4 w-4 shrink-0',
        match ($getSize()) {
            'sm' => '-ml-1.5',
            default => '-ml-2',
        },
    ]) />

    {{ $getContent() }}
</span>
