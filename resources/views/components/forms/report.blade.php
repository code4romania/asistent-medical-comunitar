@php
    $factory = $getRecord()->factory();
@endphp

<div class="w-full overflow-x-auto">
    <table class="min-w-full border-collapse table-fixed filament-tables-table text-start">
        @if (null !== ($header = $factory->getHeader()))
            <thead class="text-base bg-gray-500/5">
                @if (!empty($header['supra']))
                    <tr>
                        <th
                            class="sticky left-0 bg-white border-r"
                            rowspan="2"
                        ></th>

                        <x-reports.table.header
                            :segment="$header['supra']['segment']"
                            :columns="$header['supra']['columns']"
                            :colspan="count($header['main']['columns'])"
                        />
                    </tr>

                    <tr>
                        @for ($i = 0; $i < count($header['supra']['columns']); $i++)
                            <x-reports.table.header
                                :segment="$header['main']['segment']"
                                :columns="$header['main']['columns']"
                                class="font-normal"
                            />
                        @endfor
                    </tr>
                @else
                    <tr>
                        <th class="sticky left-0 bg-white border-r"></th>
                        <x-reports.table.header
                            :segment="$header['main']['segment']"
                            :columns="$header['main']['columns']"
                        />
                    </tr>
                @endif
            </thead>
        @endif

        <tbody class="divide-y border-y">
            @foreach ($getRecord()->data as $label => $columns)
                <tr>
                    <th class="sticky left-0 px-4 py-3 text-left bg-gray-100 border-r min-w-[5rem] max-w-[8rem]">
                        @lang("report.indicator.value.$label")
                    </th>

                    @foreach ($columns as $data)
                        @if (is_array($data))
                            @foreach ($data as $d)
                                <td class="px-2 py-3 text-center">
                                    {{ $d }}
                                </td>
                            @endforeach
                        @else
                            <td class="px-2 py-3 text-center">
                                {{ $data }}
                            </td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
