<x-filament::widget>
    <div class="relative bg-white border filament-forms-card-component rounded-xl">
        <div class="flex flex-col justify-between gap-4 px-4 py-5 md:flex-row md:items-center sm:px-6 !pb-0">
            <h3 class="text-lg font-bold text-gray-900">{{ $this->getHeading() }}</h3>

            @if (null !== ($actions = $this->getComponentActions()))
                <div class="flex flex-wrap items-center gap-4">
                    @foreach ($actions as $action)
                        {{ $action }}
                    @endforeach
                </div>
            @endif
        </div>

        <div class="px-4 py-5 sm:px-6">
            {{ $this->form }}
        </div>
    </div>
</x-filament::widget>
