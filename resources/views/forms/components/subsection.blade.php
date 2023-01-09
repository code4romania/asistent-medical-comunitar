<div {{ $attributes->class('bg-gray-50 flex items-stretch flex-col sm:flex-row') }}>
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
