@props([
    'maxContentWidth' => null,
])

<x-filament::layouts.base :title="$title">
    <div class="flex w-full min-h-screen filament-app-layout overflow-x-clip">
        <div class="flex flex-col flex-1 w-screen h-full filament-main gap-y-6 rtl:lg:pl-0">

            <x-filament::topbar />

            <div @class([
                'filament-main-content flex-1 w-full px-4 mx-auto md:px-6 lg:px-8',
                match (($maxContentWidth ??= config('filament.layout.max_content_width'))) {
                    null, '7xl', '' => 'max-w-7xl',
                    'xl' => 'max-w-xl',
                    '2xl' => 'max-w-2xl',
                    '3xl' => 'max-w-3xl',
                    '4xl' => 'max-w-4xl',
                    '5xl' => 'max-w-5xl',
                    '6xl' => 'max-w-6xl',
                    'full' => 'max-w-full',
                    default => $maxContentWidth,
                },
            ])>

                <x-filament::layouts.app.topbar.breadcrumbs :breadcrumbs="$breadcrumbs" />

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
