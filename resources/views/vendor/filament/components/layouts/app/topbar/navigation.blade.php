<nav {{ $attributes->class('overflow-x-hidden overflow-y-auto filament-sidebar-nav') }}>
    @php
        $navigation = \Filament\Facades\Filament::getNavigation();
    @endphp

    <ul class="flex flex-wrap gap-x-2 gap-y-1">
        @foreach ($navigation as $group)
            @foreach ($group->getItems() as $item)
                @if (!$item instanceof \Filament\Navigation\NavigationItem)
                    @continue
                @endif

                <x-filament::layouts.app.topbar.item
                    :active="$item->isActive()"
                    :url="$item->getUrl()"
                    :badge="$item->getBadge()"
                    :badgeColor="$item->getBadgeColor()"
                    :shouldOpenUrlInNewTab="$item->shouldOpenUrlInNewTab()"
                >
                    {{ $item->getLabel() }}
                </x-filament::layouts.app.topbar.item>
            @endforeach
        @endforeach
    </ul>
</nav>
