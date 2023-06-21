@props(['segment', 'columns'])

@foreach ($columns as $column)
    <th {{ $attributes->class('px-2 py-3') }}>
        @lang("report.segment.value.{$segment}.{$column}")
    </th>
@endforeach
