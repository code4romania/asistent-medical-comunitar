@php
    $state = $getFormattedState();
@endphp

<div
    {{ $attributes->merge($getExtraAttributes())->class([
        'filament-tables-badge-column flex',
        'px-4 py-3' => !$isInline(),
        match ($getAlignment()) {
            'start' => 'justify-start',
            'center' => 'justify-center',
            'end' => 'justify-end',
            'left' => 'justify-start rtl:flex-row-reverse',
            'center' => 'justify-center',
            'right' => 'justify-end rtl:flex-row-reverse',
            default => null,
        },
    ]) }}>
    @if (filled($state))
        <div @class([
            'inline-flex items-center justify-center space-x-1 rtl:space-x-reverse min-h-6 font-medium tracking-tight rounded-xl whitespace-nowrap',
            match ($getStateColor()) {
                'danger' => 'text-danger-800 bg-danger-100',
                'primary' => 'text-primary-800 bg-primary-100',
                'success' => 'text-success-800 bg-success-100',
                'warning' => 'text-warning-800 bg-warning-100',
                null, 'secondary' => 'text-gray-800 bg-gray-100',
                default => $getStateColor(),
            },
            match ($getSize()) {
                'xs' => 'px-2.5 text-xs',
                'sm' => 'px-2.5 text-sm',
                default => 'px-3 py-0.5 text-sm',
                'lg' => 'px-3.5 py-1 text-sm',
                'xl' => 'px-4 py-1.5 text-sm',
            },
        ])>
            <x-icon-badge-dot @class([
                'mr-0.5 h-4 w-4 shrink-0',
                match ($getSize()) {
                    'sm' => '-ml-1.5',
                    default => '-ml-2',
                },
            ]) />

            {{ $state }}
        </div>
    @endif
</div>
