@props([
    'columns' => null,
    'data' => null,
])

<div class="w-full overflow-x-scroll">
    <table class="min-w-full border-collapse table-fixed text-start">
        @if (null !== $columns)
            <thead class="text-base bg-gray-500/5">
                <x-tables::row>
                    <th scope="col" class="sticky left-0 bg-white border-r" rowspan="2"></th>

                    @foreach ($columns as $column)
                        @php
                            $suffix = data_get($column, 'suffix');
                        @endphp

                        <x-tables::header-cell
                            :name="$column['name']"
                            :rowspan="filled($suffix) ? 1 : 2"
                            class="align-top">
                            <span class="text-base font-bold text-gray-900">
                                {{ $column['label'] }}
                            </span>
                        </x-tables::header-cell>
                    @endforeach
                </x-tables::row>

                <x-tables::row>
                    @foreach ($columns as $column)
                        @if (data_get($column, 'suffix'))
                            <x-tables::header-cell class="align-top">
                                <span class="whitespace-normal">
                                    {{ $column['suffix'] }}
                                </span>
                            </x-tables::header-cell>
                        @endif
                    @endforeach
                </x-tables::row>
            </thead>
        @endif

        <tbody class="divide-y border-y">
            @foreach ($data as $label => $columns)
                <tr>
                    <th
                        class="sticky left-0 px-4 py-3 text-left bg-gray-100 border-r"
                        scope="row">
                        <span class="block w-64">
                            {{ $label }}
                        </span>
                    </th>

                    @foreach ($columns as $data)
                        @if (is_array($data))
                            @foreach ($data as $d)
                                <td class="p-4 text-right">
                                    {{ $d }}
                                </td>
                            @endforeach
                        @else
                            <td class="p-4 text-right">
                                {{ $data }}
                            </td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
