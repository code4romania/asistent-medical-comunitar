@props([
    'parentGroup' => null,
    'icon' => null,
    'items' => [],
    'label' => null,
])

<li @class([
    'filament-sidebar-group',
    'ml-11 pr-3 pt-3' => filled($parentGroup),
])>

    @if ($label)
        <button class="flex items-center justify-between w-full">
            <div @class([
                'flex items-center gap-4 text-gray-600',
                'dark:text-gray-300' => config('filament.dark_mode'),
            ])>
                @if ($icon)
                    <x-dynamic-component
                        :component="$icon"
                        class="flex-shrink-0 w-3 h-3 ml-1"
                    />
                @endif

                <p class="flex-1 text-xs font-bold tracking-wider uppercase">
                    {{ $label }}
                </p>
            </div>
        </button>
    @endif

    <ul @class(['text-sm space-y-1 -mx-3', 'mt-2' => $label])>
        @foreach ($items as $item)
            @if ($item instanceof \Filament\Navigation\NavigationItem)
                <x-layouts.app.sidebar.item
                    :active="$item->isActive()"
                    :icon="$item->getIcon()"
                    :active-icon="$item->getActiveIcon()"
                    :url="$item->getUrl()"
                    :badge="$item->getBadge()"
                    :badgeColor="$item->getBadgeColor()"
                    :shouldOpenUrlInNewTab="$item->shouldOpenUrlInNewTab()"
                >
                    {{ $item->getLabel() }}
                </x-layouts.app.sidebar.item>
            @elseif ($item instanceof \Filament\Navigation\NavigationGroup)
                <x-layouts.app.sidebar.group
                    :label="$item->getLabel()"
                    :icon="$item->getIcon()"
                    :items="$item->getItems()"
                    :parentGroup="(filled($parentGroup) ? '$parentGroup' . '.' : null) . $label"
                />
            @endif
        @endforeach
    </ul>
</li>
