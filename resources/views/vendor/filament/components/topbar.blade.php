@props([
    'breadcrumbs' => [],
])

<div>
    <div
        {{ $attributes->class([
            'filament-main-topbar sticky top-0 z-10 flex h-16 w-full shrink-0 items-center border-b bg-primary-900',
            'text-white' => !config('filament.dark_mode'),
            'dark:bg-gray-800 dark:border-gray-700' => config('filament.dark_mode'),
        ]) }}>
        <div class="flex items-center w-full px-2 sm:px-4 md:px-6 lg:px-8">
            <div class="flex items-center justify-between flex-1">
                <a
                    href="{{ config('filament.home_url') }}"
                    data-turbo="false"
                    @class(['block', 'mr-4'])>
                    <x-filament::brand class="fill-white" />
                </a>

                <nav>MENU</nav>

                <div>
                    @livewire('filament.core.global-search')

                    @livewire('filament.core.notifications')

                    <x-filament::layouts.app.topbar.user-menu />
                </div>
            </div>
        </div>
    </div>

    <nav class="px-2 py-4 mx-auto sm:px-6 lg:px-8">
        <x-filament::layouts.app.topbar.breadcrumbs :breadcrumbs="$breadcrumbs" />
    </nav>
</div>
