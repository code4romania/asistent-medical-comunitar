@props(['step', 'current', 'last'])

@php
    $completed = $step->complete();
    $current = boolval($current);
    $next = !$completed && !$current;
@endphp

<li @class(['relative', 'pb-10' => !$last])>
    @if (!$last)
        <div @class([
            'absolute left-4 top-4 -ml-px mt-0.5 h-full w-0.5',
            'bg-primary-600' => $completed,
            'bg-gray-300' => !$completed,
        ])
            aria-hidden="true">
        </div>
    @endif

    <a href="{{ $step->link }}" class="relative flex items-center w-full gap-3 group">
        <div class="flex items-center overflow-hidden">
            <div
                @class([
                    'relative z-10 flex items-center justify-center w-8 h-8 rounded-full',
                    'ring-white ring-0 sm:ring-8 border-current border-2',
                    'text-primary-100 bg-primary-600 border-transparent group-hover:bg-primary-800' => $completed,
                    'text-primary-600 bg-white' => $current,
                    'text-gray-300 bg-white group-hover:text-gray-400' => $next,
                ])>

                @if ($completed)
                    @svg('heroicon-s-check', 'w-5 h-5')
                @elseif ($current)
                    <span
                        class="w-2.5 h-2.5 rounded-full bg-current"
                        aria-hidden="true"></span>
                @else
                    <span
                        class="w-2.5 h-2.5 rounded-full bg-transparent group-hover:bg-gray-300"
                        aria-hidden="true"></span>
                @endif

            </div>
        </div>

        <span @class([
            'text-sm font-medium',
            'text-gray-900' => $completed,
            'text-primary-700' => $current,
            'text-gray-500' => $next,
        ])>
            {{ $step->title }}
        </span>
    </a>
</li>
