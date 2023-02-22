@props([
    'tabs' => [],
])

<div class="filament-forms-tabs-component">
    <nav class="filament-forms-tabs-component-header flex gap-x-[2px] overflow-y-auto">
        @foreach ($tabs as $tab)
            <a
                href="{{ $tab->getUrl() }}"
                @class([
                    'flex items-center gap-2 py-3 text-sm font-semibold border-t-2 filament-forms-tabs-component-button shrink-0 px-9 md:text-base',
                    $tab->isActive()
                        ? 'filament-forms-tabs-component-button-active bg-white text-primary-700 border-current'
                        : 'text-white bg-primary-700 border-transparent',
                ])
            >
                {{ $tab->getLabel() }}
            </a>
        @endforeach
    </nav>

    <div class="p-6 bg-white rounded-lg rounded-tl-none shadow filament-forms-tabs-component-tab focus:outline-none">
        {{ $slot }}
    </div>
</div>
