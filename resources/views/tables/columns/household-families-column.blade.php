<table class="w-full divide-y table-auto bg-gray-50 filament-tables-table text-start">
    <thead>
        <tr class="bg-gray-500/5">
            <x-tables::header-cell>Familie</x-tables::header-cell>
            <x-tables::header-cell>ID</x-tables::header-cell>
            <x-tables::header-cell>Nume</x-tables::header-cell>
            <x-tables::header-cell>Prenume</x-tables::header-cell>
            <x-tables::header-cell>Status Beneficiar</x-tables::header-cell>
            <x-tables::header-cell>CNP</x-tables::header-cell>
            <x-tables::header-cell>Vârsta</x-tables::header-cell>
            <x-tables::header-cell>Vulnerabilități</x-tables::header-cell>
            <x-tables::header-cell></x-tables::header-cell>
        </tr>
    </thead>

    <tbody class="divide-y">
        @foreach ($getState() as $family)
            @foreach ($family->beneficiaries as $beneficiary)
                <x-tables::row>
                    @if ($loop->first)
                        <x-tables::cell
                            rowspan="{{ $family->beneficiaries->count() }}"
                            class="px-4 py-3 align-top"
                        >
                            {{ $family->name }}
                        </x-tables::cell>
                    @endif

                    <x-tables::cell class="px-4 py-3">{{ $beneficiary->id }}</x-tables::cell>
                    <x-tables::cell class="px-4 py-3">{{ $beneficiary->last_name }}</x-tables::cell>
                    <x-tables::cell class="px-4 py-3">{{ $beneficiary->first_name }}</x-tables::cell>
                    <x-tables::cell class="px-4 py-3">{{ $beneficiary->status }}</x-tables::cell>
                    <x-tables::cell class="px-4 py-3">{{ $beneficiary->cnp }}</x-tables::cell>
                    <x-tables::cell class="px-4 py-3">{{ $beneficiary->age }}</x-tables::cell>
                    <x-tables::cell class="px-4 py-3">0</x-tables::cell>
                    <x-tables::cell class="px-4 py-3">
                        <a href="{{ $beneficiaryUrl($beneficiary) }}">
                            Vezi Fișa
                        </a>
                    </x-tables::cell>
                </x-tables::row>
            @endforeach
        @endforeach
    </tbody>
</table>
