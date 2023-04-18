@props([
    'label' => null,
    'color' => null,
    'content' => null,
])

@if ($content)
    <div
        x-data="{ open: false }"
        x-on:click.outside="open = false"
        class="relative"
    >
        <button
            type="button"
            x-on:click="open = true"
            @class([
                'inline-flex items-center px-5 py-2 font-medium rounded-full bg-opacity-75 hover:bg-opacity-100',
                $color,
            ])
        >
            <span class="max-w-[20ch] overflow-hidden whitespace-nowrap text-ellipsis text-sm">
                {{ $label }}
            </span>
        </button>

        <div
            class="absolute top-0 left-0 z-10 overflow-hidden text-sm rounded-lg shadow"
            x-show="open"
            x-cloak
        >
            <div class="flex items-center gap-4 px-4 py-1.5 leading-5 text-white bg-gray-700">
                <span class="whitespace-nowrap">{{ $label }}</span>

                <button x-on:click="open = false">
                    <x-heroicon-s-x-circle class="w-5 h-5 -mr-1.5" />
                </button>
            </div>

            <div class="px-4 py-3 bg-white">
                {{ $content }}
            </div>
        </div>
    </div>
@else
    <div class="relative">
        <span @class([
            'inline-flex items-center px-5 py-2 font-medium rounded-full ',
            $content ? 'bg-opacity-75 hover:bg-opacity-100' : 'cursor-default',
            $color,
        ])>
            <span class="max-w-[20ch] overflow-hidden whitespace-nowrap text-ellipsis text-sm">
                {{ $label }}
            </span>
        </span>
    </div>
@endif
