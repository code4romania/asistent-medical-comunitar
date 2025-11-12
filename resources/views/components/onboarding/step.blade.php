@props(['step', 'current', 'loop'])

@php
    $completed = $step->complete();
    $current = boolval($current);
    $next = !$completed && !$current;
@endphp

@capture($stepContent)
    <div class="flex items-center overflow-hidden">
        <div
            @class([
                'relative z-10 flex items-center justify-center w-8 h-8 rounded-full',
                'ring-white border-current border-2',
                'text-primary-100 bg-primary-600 border-transparent' => $completed,
                'text-primary-600 bg-white dark:text-primary-400 dark:bg-gray-900' => $current,
                'text-gray-300 bg-white dark:bg-gray-900 group-hover:text-gray-400' => $next,
            ])>

            @if ($completed)
                @svg('heroicon-s-check', 'w-5 h-5')
            @else
                <span
                    @class([
                        'w-2.5 h-2.5 rounded-full',
                        'bg-current' => $current,
                        'bg-transparent group-hover:bg-gray-300' => $next,
                    ])
                    aria-hidden="true"></span>
            @endif

        </div>
    </div>

    <div @class([
        'text-sm font-medium lg:text-center',
        'text-gray-900 dark:text-gray-400' => $completed,
        'text-primary-600 dark:text-primary-400' => $current,
        'text-gray-500' => $next,
    ])>
        <span class="inline-block lg:max-w-28">{{ $step->title }}</span>
    </div>
@endcapture

<li @class(['relative w-full lg:px-5', 'pb-10 lg:pb-0' => !$loop->last])>
    @if (!$loop->last)
        <div @class([
            'absolute left-4 top-4 -ml-px mt-0.5 h-full w-0.5',
            'lg:h-0.5 lg:w-full lg:left-1/2 lg:mt-0 lg:-ml-1',
            'bg-primary-600' => $completed,
            'bg-gray-300' => !$completed,
        ])
            aria-hidden="true"></div>
    @endif

    @if ($step->link && !$next)
        <a href="{{ $step->link }}" class="relative flex items-center w-full gap-3 group lg:flex-col">
            {{ $stepContent() }}
        </a>
    @else
        <div class="relative flex items-center w-full gap-3 lg:flex-col">
            {{ $stepContent() }}
        </div>
    @endif
</li>
