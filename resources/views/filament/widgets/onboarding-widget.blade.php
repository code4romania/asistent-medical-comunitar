<x-filament::widget>
    <x-filament::card :heading="__('onboarding.title')">
        <x-onboarding :onboarding="auth()->user()->onboarding()" />
    </x-filament::card>
</x-filament::widget>
