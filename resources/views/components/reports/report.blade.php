@props(['report'])

<section class="relative bg-white border filament-forms-card-component rounded-xl">
    <header class="flex flex-col justify-between gap-4 px-4 py-5 md:flex-row md:items-center sm:px-6">
        <h3 class="text-lg font-bold text-gray-900">
            {{ $report->data()->getTitle() }}
        </h3>

    </header>

    <div class="px-4 py-5 sm:px-6">
        <x-reports.table :data="$report->data()->getData()" />
    </div>
</section>
