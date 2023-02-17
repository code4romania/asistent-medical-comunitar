<div
    {{ $attributes->class([
        'filament-main-topbar sticky top-0 z-40 flex py-3 w-full shrink-0 items-center border-b bg-primary-900',
        'text-white' => !config('filament.dark_mode'),
        'dark:bg-gray-800 dark:border-gray-700' => config('filament.dark_mode'),
    ]) }}>
    <div class="flex items-center w-full px-2 sm:px-4 md:px-6 lg:px-8">
        <div
            x-data="{ menuOpen: false }"
            x-on:click.outside="menuOpen = false"
            class="flex flex-wrap items-center justify-between flex-1 gap-6"
        >
            <button
                type="button"
                x-on:click="menuOpen = !menuOpen"
                class="lg:hidden"
            >
                <x-heroicon-o-menu
                    x-show="!menuOpen"
                    class="w-6 h-6"
                />
                <x-heroicon-o-x
                    x-show="menuOpen"
                    class="w-6 h-6"
                    x-cloak
                />
            </button>

            <a
                href="{{ config('filament.home_url') }}"
                data-turbo="false"
                class="order-1 block mr-4"
            >
                <x-filament::brand class="fill-white" />
            </a>

            <x-filament::layouts.app.topbar.navigation
                class="order-3 w-full lg:hidden"
                x-show="menuOpen"
            />

            <x-filament::layouts.app.topbar.navigation class="order-2 hidden lg:block" />

            <div class="order-2 lg:order-3">
                @livewire('filament.core.global-search')

                @livewire('filament.core.notifications')

                <x-filament::layouts.app.topbar.user-menu />
            </div>
        </div>
    </div>
</div>
