@props(['record'])

@php
    $header = $record->factory()->getHeader();
    $data = $record->data;
@endphp

<div class="w-full overflow-x-auto">
    @if (null === $data)
        <x-tables::empty-state
            icon="icon-clipboard"
            heading="Heading"
            description="Description"
        />
    @else
        <table class="min-w-full border-collapse table-fixed text-start">
            @if (null !== $header)
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
                                scope="colgroup"
                            />
                        </tr>

                        <tr>
                            @for ($i = 0; $i < count($header['supra']['columns']); $i++)
                                <x-reports.table.header
                                    :segment="$header['main']['segment']"
                                    :columns="$header['main']['columns']"
                                    class="font-normal"
                                    scope="col"
                                />
                            @endfor
                        </tr>
                    @else
                        <tr>
                            <th class="sticky left-0 bg-white border-r"></th>
                            <x-reports.table.header
                                :segment="$header['main']['segment']"
                                :columns="$header['main']['columns']"
                                scope="col"
                            />
                        </tr>
                    @endif
                </thead>
            @endif

            <tbody class="divide-y border-y">
                @foreach ($data as $label => $columns)
                    <tr>
                        <th
                            class="sticky left-0 px-4 py-3 text-left bg-gray-100 border-r"
                            scope="row"
                        >
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
    @endif
</div>
