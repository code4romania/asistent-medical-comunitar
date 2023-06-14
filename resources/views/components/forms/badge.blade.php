<x-badge
    :attributes="$attributes"
    :size="$getSize()"
    :color="$getColor()"
>
    {{ $getContent() }}
</x-badge>
