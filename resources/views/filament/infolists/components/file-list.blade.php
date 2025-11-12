@php
    $files = $getState();
@endphp

<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    <ul
        {{ $attributes->merge($getExtraAttributes())->class(['text-gray-600 font-normal']) }}>
        @forelse ($files as $file)
            <li class="flex gap-1 whitespace-nowrap">
                <a
                    href="{{ $file->getFullUrl() }}"
                    class="font-medium underline truncate outline-none text-ellipsis filament-link hover:no-underline focus:underline text-primary-600 hover:text-primary-500"
                    download="{{ $file->original_file_name }}">
                    {{ $file->original_file_name }}
                </a>

                <span class="text-gray-500">
                    ({{ Number::fileSize($file->size) }})
                </span>
            </li>
        @empty
            <span class="text-gray-500">&mdash;</span>
        @endforelse
    </ul>
</x-dynamic-component>
