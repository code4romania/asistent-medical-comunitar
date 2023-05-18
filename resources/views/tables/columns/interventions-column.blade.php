<table class="w-full text-sm divide-y table-fixed bg-gray-50 filament-tables-table text-start">
    <thead>
        <tr class="bg-gray-500/5">
            <x-tables::header-cell class="w-24" />

            <x-tables::header-cell>
                @lang('field.interventions')
            </x-tables::header-cell>

            <x-tables::header-cell>
                @lang('field.type')
            </x-tables::header-cell>

            <x-tables::header-cell>
                @lang('field.status')
            </x-tables::header-cell>

            <x-tables::header-cell>
                @lang('field.services_realized')
            </x-tables::header-cell>

            {{-- <x-tables::header-cell>
                @lang('field.appointments')
            </x-tables::header-cell> --}}

            <x-tables::header-cell />
        </tr>
    </thead>

    <tbody class="divide-y">
        @foreach ($interventions() as $intervention)
            <tr>
                <td class="w-24 px-4 py-6">
                    #{{ $intervention->id }}
                </td>

                <td class="px-4 py-6">
                    {{ $getNameColumn($intervention) }}
                </td>

                <td class="px-4 py-6">
                    {{ $getTypeColumn($intervention) }}
                </td>

                <td class="px-4 py-6">
                    {{ $getStatusColumn($intervention) }}
                </td>

                <td class="px-4 py-6">
                    {{ $getServicesColumn($intervention) }}
                </td>

                {{-- <td class="px-4 py-6">
                    0
                </td> --}}

                <td class="relative px-4 py-6">
                    <x-tables::actions
                        :actions="$getActions($intervention)"
                        :record="$intervention"
                        wrap="-md"
                    />
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
