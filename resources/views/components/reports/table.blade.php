@props([
    'header' => null,
    'data',
])

<table class="w-full divide-y table-fixed filament-tables-table text-start">
    @if ($header)
        <thead>
            <tr class="bg-gray-500/5">
                @foreach ($header as $column => $label)
                    <th class="px-4 py-3 text-left">{{ $label }}</th>
                @endforeach
            </tr>
        </thead>
    @endif

    <tbody class="divide-y">
        @foreach ($data as $label => $columns)
            <tr>
                <th class="px-4 py-3 text-left bg-gray-100">
                    @lang("report.indicator.$label")
                </th>

                @foreach ($columns as $column)
                    <td class="px-4 py-3">{{ $column }}</td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
