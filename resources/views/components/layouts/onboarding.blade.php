@props([
    'title' => null,
    'maxContentWidth' => config('filament.layout.max_content_width'),
])

@php
    $maxContentWidth = match ($maxContentWidth) {
        null, '7xl', '' => 'max-w-7xl',
        'xl' => 'max-w-xl',
        '2xl' => 'max-w-2xl',
        '3xl' => 'max-w-3xl',
        '4xl' => 'max-w-4xl',
        '5xl' => 'max-w-5xl',
        '6xl' => 'max-w-6xl',
        'full' => 'max-w-full',
        default => $maxContentWidth,
    };
@endphp

<x-filament::layouts.base :title="$title">
    <div class="flex w-full min-h-screen filament-app-layout overflow-x-clip">
        <div class="flex flex-col flex-1 w-screen min-h-screen filament-main gap-y-8 rtl:lg:pl-0">
            <div
                class="sticky top-0 z-40 flex items-center w-full py-3 border-b filament-main-topbar shrink-0 bg-primary-900">
                <div class="flex items-center w-full px-2 sm:px-4 md:px-6 lg:px-8">
                    <a
                        href="{{ config('filament.home_url') }}"
                        data-turbo="false"
                        class="block">
                        <x-filament::brand class="fill-white" />
                    </a>
                </div>
            </div>

            <div @class([
                'filament-main-content flex-1 w-full px-4 mx-auto md:px-6 lg:px-8',
                $maxContentWidth,
            ])>
                {{ \Filament\Facades\Filament::renderHook('content.start') }}

                {{ $slot }}

                {{ \Filament\Facades\Filament::renderHook('content.end') }}
            </div>

            <div class="py-4 filament-main-footer shrink-0">
                <x-filament::footer />
            </div>
        </div>
    </div>
</x-filament::layouts.base>
