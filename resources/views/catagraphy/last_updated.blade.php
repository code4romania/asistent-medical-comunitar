@props(['created_at', 'updated_at', 'name', 'history_url'])

<div class="flex items-center gap-4 text-sm">
    <x-heroicon-o-clock class="w-6 h-6 text-gray-500 shrink-0" />

    <span class="flex-1">
        @lang('catagraphy.footer.updated_at', [
            'created_at' => $created_at,
            'updated_at' => $updated_at,
            'name' => $name,
        ])
    </span>

    <a
        href="{{ $history_url }}"
        class="font-semibold underline text-primary-700 hover:no-underline"
    >
        {{ __('catagraphy.footer.action') }}
    </a>
</div>
