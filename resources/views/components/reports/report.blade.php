@props([
    'actions' => null,
    'report',
])

<section class="relative bg-white border filament-forms-card-component rounded-xl">
    <header class="flex flex-col justify-between gap-4 px-4 py-5 md:flex-row md:items-center sm:px-6">
        <h3 class="text-lg font-bold text-gray-900">
            {{ $report->data()->getTitle() }}
        </h3>

        @if (null !== $actions)
            <div class="flex flex-wrap items-center gap-4">
                @foreach ($actions as $action)
                    {{ $action }}
                @endforeach
            </div>
        @endif
    </header>

    <div class="px-4 py-5 sm:px-6">
        <x-reports.table :data="$report->data()->getData()" />
    </div>
</section>
