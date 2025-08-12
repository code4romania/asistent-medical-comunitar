{{-- @use('Illuminate\Support\Number::class) --}}

<x-dynamic-component
    :component="$getFieldWrapperView()"
    :id="$getId()"
    :label="$getLabel()"
    :label-sr-only="$isLabelHidden()"
    :helper-text="$getHelperText()"
    :hint="$getHint()"
    :hint-action="$getHintAction()"
    :hint-color="$getHintColor()"
    :hint-icon="$getHintIcon()"
    :state-path="$getStatePath()">
    <ul
        {{ $attributes->merge($getExtraAttributes())->class(['filament-forms-value-component text-gray-600 font-normal']) }}>
        @forelse ($getFiles() as $file)
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
