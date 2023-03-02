@props([
    'label' => null,
    'color' => null,
    'content' => null,
])

<div class="relative">
    <button
        type="button"
        @class([
            'inline-flex items-center px-5 py-2 font-medium rounded-full hover:opacity-75',
            $color,
        ])
    >
        <span class="max-w-[20ch] overflow-hidden whitespace-nowrap text-ellipsis text-sm">
            {{ $label }}
        </span>
    </button>

    <div class="prose">{{ $content }}</div>
</div>
