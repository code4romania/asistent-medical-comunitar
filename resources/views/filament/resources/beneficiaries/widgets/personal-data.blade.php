<x-filament-widgets::widget>
    <x-filament::section>
        {{-- Widget content --}}
        <x-slot name="heading">
            <div class="flex flex-col justify-between gap-4 md:flex-row md:items-center">
                <h3 class="text-lg font-bold text-gray-900">{{ $this->getHeading() }}</h3>

                @if (filled($actions = $this->getHeaderActions()))
                    <div class="flex flex-wrap items-center gap-4">
                        @foreach ($actions as $action)
                            {{ $action }}
                        @endforeach
                    </div>
                @endif
            </div>
        </x-slot>

        {{ $this->infolist }}
    </x-filament::section>
</x-filament-widgets::widget>
