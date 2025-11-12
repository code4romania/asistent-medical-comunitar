@props(['record'])

<div class="w-full overflow-x-auto">
    @if (blank($record->data))
        <x-filament::empty-state
            icon="icon-clipboard"
            :heading="__('report.no-results.title')"
            :description="__('report.no-results.description')" />
    @elseif ($record->isList)
        <x-reports.table.list :columns="$record->columns" :data="$record->data" />
    @else
        <x-reports.table.statistic :columns="$record->columns" :data="$record->data" />
    @endif
</div>
