@if (config('app.old_url'))
    <div class="mt-2 text-sm text-center">
        {{ __('filament-breezy::default.or') }}
        <a
            class="inline-flex items-center gap-1 text-primary-600 hover:text-primary-700"
            href="{{ config('app.old_url') }}"
            target="_blank">
            <span>accesează platforma veche</span>
            <x-heroicon-s-arrow-top-right-on-square class="inline-block w-4 h-4" />
        </a>
    </div>
@endif
