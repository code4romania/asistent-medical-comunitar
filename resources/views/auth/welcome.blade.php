<div class="flex flex-col min-h-full filament-welcome-page">
    <header class="flex flex-col gap-4 mb-6 filament-header">
        <h1 class="text-2xl font-semibold tracking-tight md:text-3xl">
            {{ __('welcome.set_password.greeting', [
                'name' => $user->first_name,
            ]) }}
        </h1>

        <p class="max-w-4xl text-gray-800 md:text-xl">
            {{ __('welcome.set_password.intro') }}
        </p>
    </header>

    <div class="relative flex flex-col justify-center flex-1 bg-white border rounded-xl">
        <div class="w-full max-w-md px-4 py-10 mx-auto sm:px-6 md:py-20">
            @svg('icon', 'h-12 md:h-20 fill-primary-700 mx-auto mb-6')

            @if ($user->hasSetPassword())
                <div class="space-y-8">
                    <h1 class="text-xl font-bold text-center text-gray-900 md:text-3xl">
                        {{ __('welcome.onboarding.heading') }}
                    </h1>

                    <div class="prose">
                        <p>{{ __('welcome.onboarding.intro') }}</p>

                        <ul>
                            @foreach (__('welcome.onboarding.documents') as $document)
                                <li>{{ $document }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <x-filament::button
                        tag="a"
                        :href="route('filament.auth.login')"
                        class="w-full">
                        {{ __('welcome.onboarding.login') }}
                    </x-filament::button>
                </div>
            @else
                <form wire:submit.prevent="handle" class="space-y-8">
                    <h1 class="text-xl font-bold text-center text-gray-900 md:text-3xl">
                        {{ __('welcome.set_password.submit') }}
                    </h1>

                    {{ $this->form }}

                    <x-filament::button
                        type="submit"
                        form="handle"
                        class="w-full">
                        {{ __('welcome.set_password.submit') }}
                    </x-filament::button>
                </form>
            @endif
        </div>
    </div>
</div>
