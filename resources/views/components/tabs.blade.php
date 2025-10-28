@props([
    'tabs' => [],
    'actions' => null,
])

<div class="fi-tabs-component">
    <nav class="flex overflow-y-auto fi-tabs-component-header gap-x-[2px]">
        @foreach ($tabs as $tab)
            @if ($tab->isHidden())
                @continue
            @endif

            <a
                href="{{ $tab->getUrl() }}"
                @class([
                    'flex items-center gap-2 py-3 text-sm font-semibold border-t-2 fi-tabs-component-button shrink-0 px-9 md:text-base focus:outline-none',
                    $tab->isActive()
                        ? 'fi-tabs-component-button-active bg-white border-current dark:bg-gray-900 text-primary-600 ring-primary-600 dark:text-primary-50 dark:ring-primary-700'
                        : 'text-white bg-primary-600 border-transparent hover:bg-primary-500 dark:bg-primary-700 dark:hover:bg-primary-800',
                ])>
                {{ $tab->getLabel() }}
            </a>
        @endforeach
    </nav>

    <div
        class="fi-tabs-component-tab focus:outline-none dark:bg-gray-900">
        @if (null !== $actions)
            <div class="flex flex-wrap items-center justify-end gap-4 pb-5">
                @foreach ($actions as $action)
                    {{ $action }}
                @endforeach
            </div>
        @endif

        {{ $slot }}
    </div>
</div>
