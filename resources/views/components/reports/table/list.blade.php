@props([
    'columns' => null,
    'data' => null,
    'actions' => null,
])

<div class="w-full overflow-x-scroll">
    <table class="min-w-full border-collapse table-fixed text-start">
        {{--
        @if (null !== $columns)
            <thead class="text-base bg-gray-500/5">
                <x-tables::row>
                    @foreach ($columns as $column)
                        <x-tables::header-cell :name="$column['name']">
                            {{ $column['label'] }}
                        </x-tables::header-cell>
                    @endforeach

                    @if (filled(data_get($data, '0.actions')))
                        <x-tables::header-cell name="actions" />
                    @endif
                </x-tables::row>
            </thead>
        @endif

        <tbody class="divide-y border-y">
            @foreach ($data as $row)
                <x-tables::row>
                    @foreach ($columns as $column)
                        @php
                            $cell = data_get($row, $column['name']);
                        @endphp

                        @if (is_array($cell))
                            @foreach ($cell as $d)
                                <x-tables::cell class="px-4 py-2">
                                    {{ $d ?? '–' }}
                                </x-tables::cell>
                            @endforeach
                        @else
                            <x-tables::cell class="px-4 py-2">
                                {{ $cell ?? '–' }}
                            </x-tables::cell>
                        @endif
                    @endforeach

                    @if (filled($actions = data_get($row, 'actions')))
                        <x-tables::cell class="px-4 py-2">
                            <div class="flex justify-end w-full gap-4">
                                @foreach ($actions as $url => $label)
                                    <x-tables::link :href="$url" target="_blank">
                                        <span class="whitespace-nowrap">{{ $label }}</span>

                                        <x-heroicon-s-external-link class="w-4 h-4 shrink-0" />
                                    </x-tables::link>
                                @endforeach
                            </div>
                        </x-tables::cell>
                    @endif
                </x-tables::row>
            @endforeach
        </tbody>
        --}}
    </table>
</div>
