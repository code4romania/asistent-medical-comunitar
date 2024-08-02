@props([
    'columns' => null,
    'data' => null,
    'actions' => null,
])

<table class="min-w-full border-collapse table-fixed text-start">
    @if (null !== $columns)
        <thead class="text-base bg-gray-500/5">
            <x-tables::row>
                @foreach ($columns as $key => $label)
                    <x-tables::header-cell :name="$key">
                        {{ $label }}
                    </x-tables::header-cell>
                @endforeach

                @if (filled(data_get($data, '0.actions')))
                    <x-tables::header-cell name="actions" />
                @endif
            </x-tables::row>
        </thead>
    @endif

    <tbody class="text-sm divide-y border-y">
        @foreach ($data as $row)
            <x-tables::row>
                @foreach ($row as $key => $column)
                    @if (is_array($column))
                        @if ($key === 'actions')
                            <x-tables::cell class="px-4 py-2">
                                <div class="flex justify-end w-full gap-4">
                                    @foreach ($column as $url => $label)
                                        <x-tables::link :href="$url" target="_blank">
                                            <span>{{ $label }}</span>

                                            <x-heroicon-s-external-link class="w-4 h-4" />
                                        </x-tables::link>
                                    @endforeach
                                </div>
                            </x-tables::cell>
                        @else
                            @foreach ($column as $d)
                                <x-tables::cell class="px-4 py-2">
                                    {{ $d ?? '–' }}
                                </x-tables::cell>
                            @endforeach
                        @endif
                    @else
                        <x-tables::cell class="px-4 py-2">
                            {{ $column ?? '–' }}
                        </x-tables::cell>
                    @endif
                @endforeach
            </x-tables::row>
        @endforeach
    </tbody>
</table>
