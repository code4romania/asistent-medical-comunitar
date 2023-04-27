<table class="w-full text-sm divide-y table-fixed bg-gray-50 filament-tables-table text-start">
    <thead>
        <tr class="bg-gray-500/5">
            <x-tables::header-cell class="w-24"></x-tables::header-cell>
            <x-tables::header-cell>@lang('field.interventions')</x-tables::header-cell>
            <x-tables::header-cell>@lang('field.type')</x-tables::header-cell>
            <x-tables::header-cell>@lang('field.status')</x-tables::header-cell>
            <x-tables::header-cell>@lang('field.services_performed')</x-tables::header-cell>
            <x-tables::header-cell>@lang('field.appointments')</x-tables::header-cell>
            <x-tables::header-cell></x-tables::header-cell>
        </tr>
    </thead>

    <tbody class="divide-y">
        @foreach ($getState() as $intervention)
            <x-tables::row>
                <x-tables::cell class="w-24 px-4 py-6">#{{ $intervention->id }}</x-tables::cell>
                <x-tables::cell class="px-4 py-6">{{ $intervention->service->name }}</x-tables::cell>
                <x-tables::cell class="px-4 py-6">{{ $intervention->type->label() }}</x-tables::cell>
                <x-tables::cell class="px-4 py-6">STATUS</x-tables::cell>
                <x-tables::cell class="px-4 py-6">0/0</x-tables::cell>
                <x-tables::cell class="px-4 py-6">0</x-tables::cell>
                <x-tables::cell class="px-4 py-6">
                    @if ($intervention->isCase())
                        <x-filament::link href="#">
                            @lang('intervention.action.view_case')
                        </x-filament::link>
                    @else
                        <x-filament::link href="#">
                            @lang('intervention.action.view_individual')
                        </x-filament::link>
                    @endif
                </x-tables::cell>
            </x-tables::row>
        @endforeach
    </tbody>
</table>
