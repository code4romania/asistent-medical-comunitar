@props([
    'navigation' => [],
])

<aside>
    <div
        class="block px-4 mt-6 md:px-6 lg:hidden"
        x-data="{
            navigate: function() {
                let href = String(this.$el.value);

                if (href.startsWith(window.location.origin)) {
                    window.location.href = href;
                    return;
                }

                console.error(href + ' does not match origin ' + window.location.origin);
            }
        }"
    >
        <select
            class="block w-full text-gray-900 transition duration-75 border-gray-300 rounded-lg shadow-sm whitespace-nowrap focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 disabled:opacity-50"
            x-on:change="navigate"
        >
            @foreach ($navigation as $group)
                @foreach ($group->getItems() as $item)
                    <option
                        value="{{ $item->getUrl() }}"
                        @selected($item->isActive())
                    >{{ $item->getLabel() }}</option>
                @endforeach
            @endforeach
        </select>
    </div>

    <div
        class="filament-sidebar hidden relative inset-y-0 left-0 rtl:left-auto rtl:right-0 z-20 lg:flex flex-col h-full overflow-hidden shadow-2xl transition-all bg-white lg:border-r rtl:lg:border-r-0 rtl:lg:border-l w-[var(--sidebar-width)] lg:z-0">
        <nav class="flex-1 py-6 overflow-x-hidden overflow-y-auto filament-sidebar-nav">
            <x-layouts.app.sidebar.start />
            {{ \Filament\Facades\Filament::renderHook('sidebar.start') }}

            <ul class="px-6 space-y-6">
                @foreach ($navigation as $group)
                    <x-layouts.app.sidebar.group
                        :label="$group->getLabel()"
                        :icon="$group->getIcon()"
                        :collapsible="$group->isCollapsible()"
                        :items="$group->getItems()"
                    />

                    @if (!$loop->last)
                        <li>
                            <div @class([
                                'border-t -mr-6 rtl:-mr-auto rtl:-ml-6',
                                'dark:border-gray-700' => config('filament.dark_mode'),
                            ])></div>
                        </li>
                    @endif
                @endforeach
            </ul>

            <x-layouts.app.sidebar.end />
            {{ \Filament\Facades\Filament::renderHook('sidebar.end') }}
        </nav>

        <x-layouts.app.sidebar.footer />
    </div>
</aside>
