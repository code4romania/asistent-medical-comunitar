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
    <svg
        @class([
            'mr-1.5 h-2 w-2 text-current/50',
            match ($getSize()) {
                'sm' => '-ml-0.5',
                default => '-ml-1',
            },
        ])
        fill="currentColor"
        viewBox="0 0 8 8"
    >
        <circle
            cx="4"
            cy="4"
            r="3"
        />
    </svg>

    {{ $getContent() }}
</span>
