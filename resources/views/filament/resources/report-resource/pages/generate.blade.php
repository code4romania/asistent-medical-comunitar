<x-filament::page>
    <x-tabs :tabs="$this->getTabs()">
        <x-filament::form wire:submit.prevent="generate">
            {{ $this->form }}

            <x-filament::form.actions
                :actions="$this->getCachedFormActions()"
                :full-width="$this->hasFullWidthFormActions()"
            />
        </x-filament::form>
    </x-tabs>

    @if ($record !== null)
        <section class="relative bg-white border filament-forms-card-component rounded-xl">
            <header class="flex flex-col justify-between gap-4 px-4 py-5 md:flex-row md:items-center sm:px-6">
                <h3 class="text-lg font-bold text-gray-900">
                    // REPORT TITLE //
                </h3>

                <div class="flex flex-wrap items-center gap-4">
                    // REPORT ACTIONS //
                </div>
            </header>

            <div class="px-4 py-5 sm:px-6">
                @dump($record)
            </div>
        </section>
    @endif
</x-filament::page>
