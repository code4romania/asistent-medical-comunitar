@php
    $factory = $getRecord()->factory();
@endphp

<div class="w-full overflow-x-auto">
    <table class="min-w-full border-collapse table-fixed filament-tables-table text-start">
        @if (null !== ($header = $factory->getHeader()))
            <thead class="text-base bg-gray-500/5">
                @if (!empty($header['supra']))
                    <x-reports.table.header-row
                        :segment="$header['supra']['segment']"
                        :columns="$header['supra']['columns']"
                        :colspan="count($header['main']['columns'])"
                    />

                    <x-reports.table.header-row
                        :segment="$header['main']['segment']"
                        :columns="$header['main']['columns']"
                        class="font-normal"
                    />
                @else
                    <x-reports.table.header-row
                        :segment="$header['main']['segment']"
                        :columns="$header['main']['columns']"
                        class="font-normal"
                    />
                @endif
            </thead>
        @endif

        <tbody class="divide-y border-y">
            @foreach ($getRecord()->data as $label => $columns)
                <tr>
                    <th class="sticky left-0 px-4 py-3 text-left bg-gray-100 border-r max-w-[8rem]">
                        @lang("report.indicator.$label")
                    </th>

                    @foreach ($columns as $column)
                        <td class="px-4 py-3">{{ $column }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

