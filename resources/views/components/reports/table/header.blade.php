@props(['segment', 'columns'])

@foreach ($columns as $column)
    <th {{ $attributes->class('px-2 py-3') }}>
        @lang("report.segment.{$segment}.{$column}")
    </th>
@endforeach
