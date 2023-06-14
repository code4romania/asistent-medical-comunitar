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
        <x-badge
            :size="$getSize()"
            :color="$getStateColor()"
        >
            {{ $state }}
        </x-badge>
    @endif
</div>
