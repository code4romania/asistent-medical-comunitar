@props(['showBackButton' => true])

<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    dir="{{ __('filament-panels::layout.direction') ?? 'ltr' }}"
    @class(['fi', 'dark' => filament()->hasDarkModeForced()])>

<head>
    {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::HEAD_START) }}

    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    @if ($favicon = filament()->getFavicon())
        <link rel="icon" href="{{ $favicon }}" />
    @endif

    @php
        $brandName = trim(strip_tags(filament()->getBrandName()));
        $homeUrl = filament()->getHomeUrl();
    @endphp

    <title>
        @yield('title') - {{ $brandName }}
    </title>

    {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::STYLES_BEFORE) }}

    <style>
        [x-cloak=''],
        [x-cloak='x-cloak'],
        [x-cloak='1'] {
            display: none !important;
        }

        [x-cloak='inline-flex'] {
            display: inline-flex !important;
        }

        @media (max-width: 1023px) {
            [x-cloak='-lg'] {
                display: none !important;
            }
        }

        @media (min-width: 1024px) {
            [x-cloak='lg'] {
                display: none !important;
            }
        }
    </style>

    @filamentStyles

    {{ filament()->getTheme()->getHtml() }}
    {{ filament()->getFontHtml() }}
    {{ filament()->getMonoFontHtml() }}
    {{ filament()->getSerifFontHtml() }}

    <style>
        :root {
            --font-family: '{!! filament()->getFontFamily() !!}';
            --mono-font-family: '{!! filament()->getMonoFontFamily() !!}';
            --serif-font-family: '{!! filament()->getSerifFontFamily() !!}';
            --sidebar-width: {{ filament()->getSidebarWidth() }};
            --collapsed-sidebar-width: {{ filament()->getCollapsedSidebarWidth() }};
            --default-theme-mode: {{ filament()->getDefaultThemeMode()->value }};
        }
    </style>

    @stack('styles')

    {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::STYLES_AFTER) }}

    @if (!filament()->hasDarkMode())
        <script>
            localStorage.setItem('theme', 'light')
        </script>
    @elseif (filament()->hasDarkModeForced())
        <script>
            localStorage.setItem('theme', 'dark')
        </script>
    @else
        <script>
            const loadDarkMode = () => {
                window.theme = localStorage.getItem('theme') ?? @js(filament()->getDefaultThemeMode()->value)

                if (
                    window.theme === 'dark' ||
                    (window.theme === 'system' &&
                        window.matchMedia('(prefers-color-scheme: dark)')
                        .matches)
                ) {
                    document.documentElement.classList.add('dark')
                }
            }

            loadDarkMode()

            document.addEventListener('livewire:navigated', loadDarkMode)
        </script>
    @endif

    {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::HEAD_END) }}
</head>

<body @class(['fi-body', 'fi-panel-' . filament()->getId()])>
    {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::BODY_START) }}

    <div class="flex flex-col min-h-screen">
        <div class="fi-topbar-ctn">
            <nav class="fi-topbar">
                <div class="flex fi-topbar-start">
                    <a {{ \Filament\Support\generate_href_html($homeUrl) }}>
                        <x-filament-panels::logo />
                    </a>
                </div>
            </nav>
        </div>

        <div class="fi-simple-layout">
            <div class="fi-simple-main-ctn">
                <main class="fi-simple-page">
                    <div class="fi-simple-page-content">
                        <p
                            class="text-2xl font-extrabold text-primary-600 dark:text-primary-300">
                            @yield('code')
                        </p>

                        <h1 class="text-3xl font-bold tracking-tight sm:text-5xl md:text-6xl">
                            @yield('title')
                        </h1>

                        <p class="text-lg leading-7 text-gray-600 dark:text-gray-400">
                            @yield('message')
                        </p>

                        @if ($showBackButton)
                            <div>
                                <x-filament::button
                                    :href="$homeUrl"
                                    :icon="\Filament\Support\Icons\Heroicon::ArrowLeft"
                                    tag="a">
                                    @lang('app.action.backHome')
                                </x-filament::button>
                            </div>
                        @endif
                    </div>
                </main>
            </div>
        </div>

        @livewire(Filament\Livewire\Notifications::class)

        {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::SCRIPTS_BEFORE) }}

        @filamentScripts(withCore: true)

        @if (filament()->hasBroadcasting() && config('filament.broadcasting.echo'))
            <script data-navigate-once>
                window.Echo = new window.EchoFactory(@js(config('filament.broadcasting.echo')))

                window.dispatchEvent(new CustomEvent('EchoLoaded'))
            </script>
        @endif

        @if (filament()->hasDarkMode() && !filament()->hasDarkModeForced())
            <script>
                loadDarkMode()
            </script>
        @endif

        @stack('scripts')

        {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::SCRIPTS_AFTER) }}

        {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::BODY_END) }}
</body>

</html>
