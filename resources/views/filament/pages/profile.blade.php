<x-filament::page>
    <form
        wire:submit.prevent="submit"
        class="space-y-6"
    >
        <div class="filament-forms-tabs-component">
            <nav class="filament-forms-tabs-component-header flex gap-x-[2px] overflow-y-auto">
                @foreach ($this->getSections() as $key => $label)
                    <a
                        href="{{ route("filament.pages.account/profile/$key") }}"
                        @class([
                            'flex items-center gap-2 py-3 text-sm font-semibold border-t-2 filament-forms-tabs-component-button shrink-0 px-9 md:text-base',
                            'text-white bg-primary-700 border-transparent' =>
                                $key !== $this->getActiveSection(),
                            'filament-forms-tabs-component-button-active bg-white text-primary-700 border-current' =>
                                $key === $this->getActiveSection(),
                        ])
                    >
                        <span>{{ $label }}</span>
                    </a>
                @endforeach
            </nav>

            <div
                class="p-6 bg-white rounded-lg rounded-tl-none shadow filament-forms-tabs-component-tab focus:outline-none">
                {{ $this->form }}
            </div>
        </div>

        <div class="flex flex-wrap items-center justify-start gap-4">
            <x-filament::button type="submit">
                Save
            </x-filament::button>

            <x-filament::button
                type="button"
                color="secondary"
                tag="a"
                href="$this->cancel_button_url"
            >
                Cancel
            </x-filament::button>
        </div>
    </form>
</x-filament::page>
