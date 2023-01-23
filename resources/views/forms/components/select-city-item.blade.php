<div class="relative flex items-baseline gap-2">
    <span class="font-normal truncate">{{ $name }}</span>

    @if ($parent_name)
        <span
            class="inline-flex items-center rounded bg-gray-100 px-2 py-0.5 text-xs text-gray-800">{{ $parent_name }}</span>
    @endif
</div>
