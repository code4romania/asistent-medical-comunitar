@props(['type', 'title', 'columns' => null, 'data' => []])

@php
    $isList = $type->is(\App\Enums\Report\Type::LIST);

    if (filled($columns)) {
        $headerColumns = collect($columns)->when(
            !$isList,
            fn($cols) => $cols->prepend([
                'name' => 'indicator',
                'label' => 'Indicator',
            ]),
        );
    } else {
        $headerColumns = collect([
            ['name' => 'indicator', 'label' => 'Indicator'],
            ['name' => '0', 'label' => 'Valoare'],
        ]);
    }

    $records = $isList
        ? collect($data)->values()
        : collect($data)->map(fn($values, $indicator) => ['indicator' => $indicator, ...(array) $values])->values();

    $hasActions = $isList && filled(data_get($records->first(), 'actions'));

    $alignEnd = fn(string $name, mixed $value): bool => $name === 'id' || is_numeric($value);

    $format = fn(mixed $value): mixed => is_float($value) ? \Illuminate\Support\Number::format($value, 1) : $value;
@endphp

<x-filament::section :heading="$title" :hasContentEl="false">
    @if ($records->isEmpty())
        <div class="flex flex-col items-center justify-center gap-2 py-8 text-center">
            <x-heroicon-o-x-mark class="w-8 h-8 text-gray-400 dark:text-gray-500" />

            <p class="text-sm font-medium text-gray-950 dark:text-white">
                {{ __('report.no-results.title') }}
            </p>

            <p class="text-sm text-gray-500 dark:text-gray-400">
                {{ __('report.no-results.description') }}
            </p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="fi-ta-table">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-white/10">
                        @foreach ($headerColumns as $column)
                            <th @class([
                                'fi-ta-header-cell ',
                                'text-end' => $alignEnd(
                                    $column['name'],
                                    data_get($records->first(), $column['name'])),
                                'text-start' => !$alignEnd(
                                    $column['name'],
                                    data_get($records->first(), $column['name'])),
                            ])>
                                {{ data_get($column, 'label') }}

                                @if (filled($suffix = data_get($column, 'suffix')))
                                    <small
                                        class="block font-normal text-gray-500 dark:text-gray-400">({{ $suffix }})</small>
                                @endif
                            </th>
                        @endforeach

                        @if ($hasActions)
                            <th class="px-3 py-3"></th>
                        @endif
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200 dark:divide-white/10">
                    @foreach ($records as $record)
                        <tr>
                            @foreach ($headerColumns as $column)
                                @php($value = data_get($record, $column['name']))

                                <td @class([
                                    'fi-ta-cell',
                                    'fi-align-end' => $alignEnd($column['name'], $value),
                                    'fi-align-start' => !$alignEnd($column['name'], $value),
                                ])>
                                    <div class="fi-ta-col">
                                        <div @class([
                                            'fi-size-sm fi-ta-text-item fi-wrapped fi-ta-text',
                                            'fi-align-end' => $alignEnd($column['name'], $value),
                                            'fi-align-start' => !$alignEnd($column['name'], $value),
                                        ])>
                                            {{ $format($value) ?? '–' }}
                                        </div>
                                    </div>
                                </td>
                            @endforeach

                            @if ($hasActions)
                                <td class="px-3 py-3 text-end">
                                    <div class="flex justify-end gap-3">
                                        @foreach (data_get($record, 'actions', []) as $url => $label)
                                            <a
                                                href="{{ $url }}"
                                                class="inline-flex items-center gap-1 font-medium text-primary-600 hover:text-primary-500 dark:text-primary-400">
                                                <span class="whitespace-nowrap">{{ $label }}</span>

                                                <x-heroicon-m-arrow-top-right-on-square class="w-4 h-4 shrink-0" />
                                            </a>
                                        @endforeach
                                    </div>
                                </td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</x-filament::section>
