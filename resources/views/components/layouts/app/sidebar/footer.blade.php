<header @class([
    'border-b h-[4rem] shrink-0 flex items-center justify-center relative',
    'dark:border-gray-700' => config('filament.dark_mode'),
])>
    <div
        @class([
            'flex items-center justify-center px-6 w-full',
            'lg:px-4' =>
                config('filament.layout.sidebar.is_collapsible_on_desktop') &&
                config('filament.layout.sidebar.collapsed_width') !== 0,
        ])
        x-show="$store.sidebar.isOpen || @js(!config('filament.layout.sidebar.is_collapsible_on_desktop')) || @js(config('filament.layout.sidebar.collapsed_width') === 0)"
        x-transition:enter="lg:transition delay-100"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
    >
        @if (config('filament.layout.sidebar.is_collapsible_on_desktop') &&
                config('filament.layout.sidebar.collapsed_width') !== 0)
            <button
                type="button"
                class="items-center justify-center hidden w-10 h-10 rounded-full filament-sidebar-collapse-button shrink-0 lg:flex text-primary-500 hover:bg-gray-500/5 focus:bg-primary-500/10 focus:outline-none"
                x-bind:aria-label="$store.sidebar.isOpen ? '{{ __('filament::layout.buttons.sidebar.collapse.label') }}' :
                    '{{ __('filament::layout.buttons.sidebar.expand.label') }}'"
                x-on:click.stop="$store.sidebar.isOpen ? $store.sidebar.close() : $store.sidebar.open()"
                x-transition:enter="lg:transition delay-100"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
            >
                <svg
                    class="w-6 h-6"
                    width="24"
                    height="24"
                    viewBox="0 0 24 24"
                    fill="none"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M20.25 7.5L16 12L20.25 16.5M3.75 12H12M3.75 17.25H16M3.75 6.75H16"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />
                </svg>
            </button>
        @endif

    </div>

    @if (config('filament.layout.sidebar.is_collapsible_on_desktop'))
        <button
            type="button"
            class="flex items-center justify-center w-10 h-10 rounded-full filament-sidebar-close-button shrink-0 text-primary-500 hover:bg-gray-500/5 focus:bg-primary-500/10 focus:outline-none"
            x-bind:aria-label="$store.sidebar.isOpen ? '{{ __('filament::layout.buttons.sidebar.collapse.label') }}' :
                '{{ __('filament::layout.buttons.sidebar.expand.label') }}'"
            x-on:click.stop="$store.sidebar.isOpen ? $store.sidebar.close() : $store.sidebar.open()"
            x-show="(! $store.sidebar.isOpen) && @js(config('filament.layout.sidebar.collapsed_width') !== 0)"
            x-transition:enter="lg:transition delay-100"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
        >
            <svg
                class="w-6 h-6"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="2"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"
                />
            </svg>
        </button>
    @endif
</header>
