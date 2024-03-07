<x-filament-breezy::auth-card action="authenticate">

    <div class="flex justify-center w-full">
        <x-filament::brand />
    </div>

    <div>
        <h2 class="text-2xl font-bold tracking-tight text-center">
            {{ __('filament::login.heading') }}
        </h2>
        @if (config('filament-breezy.enable_registration'))
            <p class="mt-2 text-sm text-center">
                {{ __('filament-breezy::default.or') }}
                <a class="text-primary-600" href="{{ route(config('filament-breezy.route_group_prefix') . 'register') }}">
                    {{ __('filament-breezy::default.registration.heading') }}
                </a>
            </p>
        @endif

        @if (config('app.old_url'))
            <div class="mt-2 text-sm text-center">
                {{ __('filament-breezy::default.or') }}
                <a class="inline-flex items-center gap-1 text-primary-600 hover:text-primary-700"
                    href="{{ config('app.old_url') }}">
                    <span>accesează platforma veche</span>
                    <x-heroicon-s-external-link class="inline-block w-4 h-4" />
                </a>
            </div>
        @endif
    </div>

    @session('error')
        <div class="p-4 border-l-4 border-danger-400 bg-danger-50">
            <div class="flex gap-3">
                <x-heroicon-s-exclamation class="w-5 h-5 text-danger-400 shrink-0" />

                <p class="text-sm text-danger-700">
                    {{ $value }}
                </p>
            </div>
        </div>
    @endsession

    {{ $this->form }}

    <x-filament::button type="submit" class="w-full" form="authenticate">
        {{ __('filament::login.buttons.submit.label') }}
    </x-filament::button>

    <div class="text-center">
        <a class="text-primary-600 hover:text-primary-700"
            href="{{ route(config('filament-breezy.route_group_prefix') . 'password.request') }}">{{ __('filament-breezy::default.login.forgot_password_link') }}</a>
    </div>
</x-filament-breezy::auth-card>
