@php
    $state = $getFormattedState();
    
    $stateColor = match ($getStateColor()) {
        'danger' => 'text-danger-800 bg-danger-100',
        'primary' => 'text-primary-800 bg-primary-100',
        'success' => 'text-success-800 bg-success-100',
        'warning' => 'text-warning-800 bg-warning-100',
        null, 'secondary' => 'text-gray-800 bg-gray-100',
        default => $getStateColor(),
    };
    
    $stateIcon = $getStateIcon();
    $iconPosition = $getIconPosition();
    $iconClasses = 'w-4 h-4';
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
            'inline-flex items-center justify-center space-x-1 rtl:space-x-reverse min-h-6 px-2 py-0.5 text-sm font-medium tracking-tight rounded-xl whitespace-nowrap',
            $stateColor => $stateColor,
        ])>
            @if ($stateIcon && $iconPosition === 'before')
                <x-dynamic-component
                    :component="$stateIcon"
                    :class="$iconClasses"
                />
            @endif

            <span>
                {{ $state }}
            </span>

            @if ($stateIcon && $iconPosition === 'after')
                <x-dynamic-component
                    :component="$stateIcon"
                    :class="$iconClasses"
                />
            @endif
        </div>
    @endif
</div>
