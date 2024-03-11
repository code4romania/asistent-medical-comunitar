{{ \Filament\Facades\Filament::renderHook('footer.before') }}

<div @class([
    'flex items-center filament-footer',
    'text-sm text-center text-gray-400',
    auth()->check()
        ? 'justify-between w-full mx-auto p-4 md:px-6 lg:px-8'
        : 'justify-center',
])>
    <span class="block sm:inline-flex sm:text-left">
        {{ \Filament\Facades\Filament::renderHook('footer.start') }}
    </span>

    <span class="block sm:inline-flex sm:text-right">
        {{ \Filament\Facades\Filament::renderHook('footer.end') }}
    </span>
</div>

{{ \Filament\Facades\Filament::renderHook('footer.after') }}
