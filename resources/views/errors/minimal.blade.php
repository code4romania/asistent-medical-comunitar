@props(['showBackButton' => true])

@php
    $homeUrl = filament()->getHomeUrl();
@endphp

<x-layouts.minimal>
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
</x-layouts.minimal>
