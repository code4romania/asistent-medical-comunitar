@props([
    'columns' => null,
    'data' => null,
])

<div class="w-full overflow-x-scroll">
    <table class="min-w-full border-collapse table-fixed text-start">
        @if (null !== $columns)
            <thead class="text-base bg-gray-500/5">
                <tr>
                    <th scope="col" class="sticky left-0 bg-white border-r"></th>

                    @foreach ($columns as $key => $label)
                        <th scope="col" class="px-2 py-3">
                            {{ $label }}
                        </th>
                    @endforeach
                </tr>
            </thead>
        @endif

        <tbody class="divide-y border-y">
            @foreach ($data as $label => $columns)
                <tr>
                    <th
                        class="sticky left-0 px-4 py-3 text-left bg-gray-100 border-r"
                        scope="row">
                        <span class="block w-64">
                            {{ $label }}
                        </span>
                    </th>

                    @foreach ($columns as $data)
                        @if (is_array($data))
                            @foreach ($data as $d)
                                <td class="p-4 text-center">
                                    {{ $d }}
                                </td>
                            @endforeach
                        @else
                            <td class="p-4 text-center">
                                {{ $data }}
                            </td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
