@props([
    'breadcrumbs' => [],
])

<nav {{ $attributes->class(['filament-breadcrumbs flex-1']) }}>
    <ul class="flex items-center gap-2 text-sm font-medium">
        @foreach ($breadcrumbs as $url => $label)
            <li>
                @if (is_int($url))
                    <span class="text-gray-500">{{ $label }}</span>
                @else
                    <a
                        href="{{ $url }}"
                        @class([
                            $loop->last && !$loop->first ? 'text-gray-500' : 'text-primary-700',
                        ])
                    >{{ $label }}</a>
                @endif

            </li>

            @if (!$loop->last)
                <li aria-hidden="true">
                    <x-icon-breadcrumbs-divider class="w-5 h-5 text-gray-300" />
                </li>
            @endif
        @endforeach
    </ul>
</nav>
