<x-filament::header>
    <x-slot name="heading">
        @lang('user.profile.my_profile')
    </x-slot>

    @if ($subheading = $this->getSubheading())
        <x-slot name="subheading">
            {{ $subheading }}
        </x-slot>
    @endif
</x-filament::header>
