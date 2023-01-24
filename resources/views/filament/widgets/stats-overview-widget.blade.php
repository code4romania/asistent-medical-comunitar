<x-filament::widget class="filament-stats-overview-widget">
    <x-filament::header.subheading class="mb-2 font-semibold">
        {{ $this->getHeading() }}
    </x-filament::header.subheading>

    <div {!! ($pollingInterval = $this->getPollingInterval()) ? "wire:poll.{$pollingInterval}" : '' !!}>
        <x-filament::stats :columns="$this->getColumns()">
            @foreach ($this->getCachedCards() as $card)
                {{ $card }}
            @endforeach
        </x-filament::stats>
    </div>
</x-filament::widget>
