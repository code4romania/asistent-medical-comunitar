<x-forms::actions.action
    :action="$action"
    :label="$getLabel()"
    component="forms::link"
    class="-my-2 text-xs filament-forms-link-action">
    {{ $getLabel() }}
</x-forms::actions.action>
