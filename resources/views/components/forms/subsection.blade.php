@capture($subsection)
    <div class="flex flex-col items-stretch min-h-full bg-gray-50 sm:flex-row">
        <div class="p-3 bg-gray-200 shrink-0">
            <x-dynamic-component
                :component="$getIcon()"
                class="w-6 h-6"
            />
        </div>

        <div class="flex-1 p-3 sm:p-6">
            {{ $getChildComponentContainer() }}
        </div>
    </div>
@endcapture

@if (null !== ($title = $getTitle()))
    <div {{ $attributes->merge($getExtraAttributes()) }}>
        <h3 class="mb-3 text-lg font-semibold text-gray-900">
            {{ $title }}
        </h3>

        {{ $subsection() }}
    </div>
@else
    {{ $subsection() }}
@endif
