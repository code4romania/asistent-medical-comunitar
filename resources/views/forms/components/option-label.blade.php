<div class="relative inline-flex items-baseline gap-1 -mr-1">
    <span class="font-normal truncate">{{ $name }}</span>

    @if ($suffix)
        <span class="text-xs font-light">
            ({{ $suffix }})
        </span>
    @endif
</div>
