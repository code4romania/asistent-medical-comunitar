@props([
    'breadcrumbs' => [],
])

<div {{ $attributes->class(['filament-breadcrumbs flex-1']) }}>
    <ul @class([
        'flex gap-4 items-center font-medium text-sm',
        'dark:text-white' => config('filament.dark_mode'),
    ])>
        @foreach ($breadcrumbs as $url => $label)
            <li>
                <a
                    href="{{ is_int($url) ? '#' : $url }}"
                    @class([
                        $loop->last && !$loop->first ? 'text-gray-500' : 'text-primary-700',
                        'dark:text-gray-300' =>
                            (!$loop->last || $loop->first) && config('filament.dark_mode'),
                        'dark:text-gray-400' =>
                            $loop->last && !$loop->first && config('filament.dark_mode'),
                    ])>
                    {{ $label }}
                </a>
            </li>

            @if (!$loop->last)
                <li @class([
                    'h-6 border-r border-gray-300 -skew-x-12',
                    'dark:border-gray-500' => config('filament.dark_mode'),
                ])></li>
            @endif
        @endforeach
    </ul>
</div>
