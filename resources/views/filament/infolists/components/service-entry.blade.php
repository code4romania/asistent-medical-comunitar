@php
    $services = collect($getState());
@endphp

<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    <ul {{ $getExtraAttributeBag()->class(['grid gap-2']) }}>
        @forelse ($services as $service)
            <li class="px-2 py-3 bg-gray-100 border-l-8 border-gray-200 dark:bg-gray-800 dark:border-gray-600">
                {{ $service }}
            </li>
        @empty
            <span class="text-gray-500">&mdash;</span>
        @endforelse
    </ul>
</x-dynamic-component>
