@props(['showBackButton' => true])

<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    dir="{{ __('filament::layout.direction') ?? 'ltr' }}"
    class="antialiased bg-gray-100 filament js-focus-visible">

<head>
    {{ \Filament\Facades\Filament::renderHook('head.start') }}

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @foreach (\Filament\Facades\Filament::getMeta() as $tag)
        {{ $tag }}
    @endforeach

    @if ($favicon = config('filament.favicon'))
        <link rel="icon" href="{{ $favicon }}">
    @endif

    <title>@yield('title') - {{ config('filament.brand') }}</title>

    <style>
        [x-cloak=""],
        [x-cloak="x-cloak"],
        [x-cloak="1"] {
            display: none !important;
        }

        @media (max-width: 1023px) {
            [x-cloak="-lg"] {
                display: none !important;
            }
        }

        @media (min-width: 1024px) {
            [x-cloak="lg"] {
                display: none !important;
            }
        }

        :root {
            --sidebar-width: {{ config('filament.layout.sidebar.width') ?? '20rem' }};
            --collapsed-sidebar-width: {{ config('filament.layout.sidebar.collapsed_width') ?? '5.4rem' }};
        }
    </style>

    @if (filled($fontsUrl = config('filament.google_fonts')))
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="{{ $fontsUrl }}" rel="stylesheet" />
    @endif

    @vite('resources/css/app.css')

    @if (config('filament.dark_mode'))
        <script>
            const theme = localStorage.getItem('theme')

            if ((theme === 'dark') || (!theme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark')
            }
        </script>
    @endif

    {{ \Filament\Facades\Filament::renderHook('head.end') }}
</head>

<body @class([
    'filament-body bg-gray-100 text-gray-900',
    'dark:text-gray-100 dark:bg-gray-900' => config('filament.dark_mode'),
])>
    {{ \Filament\Facades\Filament::renderHook('body.start') }}

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

            <main
                class="flex items-center justify-center flex-auto w-full px-6 py-24 mx-auto filament-main-content md:px-6 lg:px-8 max-w-7xl">

                <div>
                    <p class="text-2xl font-extrabold text-primary-700">
                        @yield('code')
                    </p>

                    <h1 class="mt-4 text-3xl font-bold tracking-tight text-gray-900 sm:text-5xl md:text-6xl">
                        @yield('title')
                    </h1>

                    <p class="mt-6 text-lg leading-7 text-gray-600">
                        @yield('message')
                    </p>

                    @if ($showBackButton)
                        <div class="mt-10">

                            <a
                                href="{{ route('filament.pages.dashboard') }}"
                                class="filament-button filament-button-size-sm inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors focus:outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset min-h-[2rem] px-3 text-sm shadow text-white focus:ring-white border-transparent bg-primary-700 hover:bg-primary-600 focus:bg-primary-600 focus:ring-offset-primary-600 filament-tables-button-action">

                                <x-heroicon-s-arrow-left
                                    class="filament-button-icon w-4 h-4 mr-1 -ml-1.5 rtl:ml-1 rtl:-mr-1.5" />

                                @lang('app.action.backHome')
                            </a>
                        </div>
                    @endif

                </div>
            </main>
        </div>
    </div>

    @if (config('filament.broadcasting.echo'))
        <script defer
            src="{{ route('filament.asset', [
                'id' => Filament\get_asset_id('echo.js'),
                'file' => 'echo.js',
            ]) }}">
        </script>

        <script>
            window.addEventListener('DOMContentLoaded', () => {
                window.Echo = new window.EchoFactory(@js(config('filament.broadcasting.echo')))

                window.dispatchEvent(new CustomEvent('EchoLoaded'))
            })
        </script>
    @endif

    {{ \Filament\Facades\Filament::renderHook('body.end') }}
</body>

</html>
