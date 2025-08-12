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
        {{ $attributes->merge($getExtraAttributes())->class(['grid gap-2']) }}>
        @forelse (collect($getState()) as $service)
            <li class="px-2 py-3 bg-gray-100 border-l-8 border-gray-200">
                {{ $service }}
            </li>
        @empty
            <span class="text-gray-500">&mdash;</span>
        @endforelse
    </ul>
</x-dynamic-component>
