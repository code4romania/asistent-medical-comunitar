@props([
    'columns' => null,
    'data' => null,
])

<div class="w-full overflow-x-scroll">
    <table class="min-w-full border-collapse table-fixed text-start">
        @if (null !== $columns)
            <thead class="text-base bg-gray-50">
                <x-tables::row class="divide-x divide-gray-200">
                    <th scope="col" class="sticky left-0 bg-white"></th>

                    @foreach ($columns as $column)
                        @php
                            $suffix = data_get($column, 'suffix');
                        @endphp

                        <x-tables::header-cell
                            scope="col"
                            :name="$column['name']"
                            alignment="right"
                            class="align-top">
                            <div class="text-right">
                                <span class="block text-base font-bold text-gray-900">
                                    {{ $column['label'] }}
                                </span>

                                @if (data_get($column, 'suffix'))
                                    <span class="whitespace-normal">
                                        {{ $column['suffix'] }}
                                    </span>
                                @endif
                            </div>
                        </x-tables::header-cell>
                    @endforeach
                </x-tables::row>
            </thead>
        @endif

        <tbody class="divide-y border-y">
            @foreach ($data as $label => $values)
                <x-tables::row class="divide-x divide-gray-200">
                    <th
                        class="sticky left-0 px-4 py-3 text-left bg-gray-50"
                        scope="row">
                        <span class="block w-64">
                            {{ $label }}
                        </span>
                    </th>

                    @foreach ($columns as $column)
                        <td @class([
                            'p-4 text-right',
                            'bg-gray-50 font-bold' => $column['name'] === 'total',
                        ])>
                            {{ data_get($values, $column['name']) }}
                        </td>
                    @endforeach
                </x-tables::row>
            @endforeach
        </tbody>
    </table>
</div>
