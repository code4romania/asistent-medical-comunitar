@php
    $title ??= $this->getTitle();
    $heading ??= $this->getHeading();
    $subheading ??= $this->getSubHeading();
    $hasSetPassword = $this->user->hasSetPassword();
@endphp

<div class="px-4 fi-simple-page md:px-6 lg:px-8">
    <div class="max-w-md fi-simple-page-content">
        @if (filled($heading) || filled($subheading))
            <x-filament::section :contained="false">
                <div class="flex flex-col gap-4 mb-6">
                    <h1 class="text-2xl font-semibold tracking-tight md:text-3xl">
                        {{ $heading }}
                    </h1>

                    <p class="text-gray-800">
                        {{ $subheading }}
                    </p>
                </div>
            </x-filament::section>
        @endif

        <x-filament::section>
            <x-icon-heart class="h-12 mx-auto my-6 md:h-16 fill-primary-700" />

            <h1 class="mb-8 text-xl font-bold text-center text-gray-900 md:text-2xl">
                {{ $title }}
            </h1>

            @if ($hasSetPassword)
                <div class="space-y-8">
                    <div class="prose">
                        <p>{{ $this->getOnboardingIntro() }}</p>

                        <ul>
                            @foreach ($this->getOnboardingList() as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <x-filament::button
                        tag="a"
                        :href="\Filament\Facades\Filament::getLoginUrl()"
                        class="w-full">
                        {{ __('welcome.onboarding.login') }}
                    </x-filament::button>
                </div>
            @else
                {{ $this->content }}
            @endif
        </x-filament::section>
    </div>
</div>
