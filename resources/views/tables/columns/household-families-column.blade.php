@php
    $household = $getState();
@endphp

<table class="w-full text-sm divide-y table-fixed bg-gray-50 filament-tables-table text-start">
    <thead>
        <tr class="bg-gray-500/5">
            <x-tables::header-cell>
                @lang('field.family')
            </x-tables::header-cell>

            <x-tables::header-cell class="w-24">
                @lang('field.id')
            </x-tables::header-cell>

            <x-tables::header-cell>
                @lang('field.last_name')
            </x-tables::header-cell>

            <x-tables::header-cell>
                @lang('field.first_name')
            </x-tables::header-cell>

            <x-tables::header-cell>
                @lang('field.status')
            </x-tables::header-cell>

            <x-tables::header-cell>
                @lang('field.cnp')
            </x-tables::header-cell>

            <x-tables::header-cell class="w-24">
                @lang('field.age')
            </x-tables::header-cell>

            <x-tables::header-cell class="w-24">
                @lang('field.vulnerabilities')
            </x-tables::header-cell>

            <x-tables::header-cell />
        </tr>
    </thead>

    <tbody class="divide-y">

        @forelse ($household as $family)
            @forelse ($family->beneficiaries as $beneficiary)
                <tr>
                    @if ($loop->first)
                        <td
                            rowspan="{{ $family->beneficiaries->count() }}"
                            class="px-4 py-3 align-top"
                        >
                            {{ $family->name }}
                        </td>
                    @endif

                    <td class="px-4 py-3">
                        #{{ $beneficiary->id }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $beneficiary->last_name }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $beneficiary->first_name }}
                    </td>

                    <td class="px-4 py-3">
                        <x-badge :color="$beneficiary->status->color()">
                            {{ $beneficiary->status->label() }}
                        </x-badge>
                    </td>

                    <td class="px-4 py-3">
                        {{ $beneficiary->cnp ?? '–' }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $beneficiary->age }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $beneficiary->catagraphy->all_valid_vulnerabilities->count() ?: '–' }}
                    </td>

                    <td class="relative px-4 py-6">
                        <x-tables::actions
                            :actions="$getActions($beneficiary)"
                            :record="$beneficiary"
                            wrap="-md"
                        />
                    </td>
                </tr>
            @empty
                <tr>
                    <td
                        rowspan="{{ $family->beneficiaries->count() }}"
                        class="px-4 py-3 align-top"
                    >
                        {{ $family->name }}
                    </td>

                    <td
                        colspan="8"
                        class="px-4 py-6 text-center"
                    >
                        @lang('household.empty_beneficiaries')
                    </td>
                </tr>
            @endforelse
        @empty
            <tr>

                <td
                    colspan="9"
                    class="px-4 py-6 text-center"
                >
                    @lang('household.empty_families')
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
