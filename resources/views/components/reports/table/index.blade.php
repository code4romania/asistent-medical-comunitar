@props(['record'])

<div class="w-full overflow-x-auto">
    @if (blank($record->data))
        <x-tables::empty-state
            icon="icon-clipboard"
            heading="Heading"
            description="Description" />
    @elseif ($record->isList)
        <x-reports.table.list :columns="$record->columns" :data="$record->data" :actions="$record->actions" />
    @else
        <x-reports.table.statistic :columns="$record->columns" :data="$record->data" />
    @endif
</div>
