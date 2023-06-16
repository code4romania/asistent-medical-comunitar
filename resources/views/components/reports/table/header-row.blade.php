@props(['segment', 'columns'])

<tr>
    <th class="sticky left-0 bg-white border-r"></th>
    @foreach ($columns as $column)
        <th {{ $attributes->class('px-4 py-3') }}>
            @lang("report.segment.{$segment}.{$column}")
        </th>
    @endforeach
</tr>
