@props([
    'columns' => null,
    'data' => null,
    'actions' => null,
])

@dump($data, $actions)

<table class="min-w-full border-collapse table-fixed text-start">
    @if (null !== $columns)
        <thead class="text-base bg-gray-500/5">
            <x-tables::row>
                @foreach ($columns as $key => $label)
                    <x-tables::header-cell :name="$key">
                        {{ $label }}
                    </x-tables::header-cell>
                @endforeach

                @if (filled($actions))
                    <x-tables::header-cell name="actions" />
                @endif
            </x-tables::row>
        </thead>
    @endif

    <tbody class="text-sm divide-y border-y">
        @foreach ($data as $label => $columns)
            <x-tables::row>
                @foreach ($columns as $data)
                    @if (is_array($data))
                        @foreach ($data as $d)
                            <x-tables::cell class="px-4 py-2">
                                {{ $d ?? '–' }}
                            </x-tables::cell>
                        @endforeach
                    @else
                        <x-tables::cell class="px-4 py-2">
                            {{ $data ?? '–' }}
                        </x-tables::cell>
                    @endif
                @endforeach

                @if (filled($actions))
                    <td class="px-2 py-3 text-right">
                        @dump($actions)
                    </td>
                @endif
            </x-tables::row>
        @endforeach
    </tbody>
</table>
