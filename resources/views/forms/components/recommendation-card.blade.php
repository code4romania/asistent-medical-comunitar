<div
    {!! $getId() ? "id=\"{$getId()}\"" : null !!}
    {{ $attributes->merge($getExtraAttributes())->class([
            'flex flex-col h-full overflow-hidden',
            'filament-forms-card-component bg-white rounded-xl border relative',
            'dark:border-gray-600 dark:bg-gray-800' => config('forms.dark_mode'),
        ]) }}>

    @if (null !== ($pointer = $getPointer()))
        <div
            @class([
                'hidden lg:block absolute w-4 h-4 rotate-45 bg-white border bottom-full -top-2',
                match ($pointer) {
                    'left' => 'lg:-ml-2 lg:left-1/4',
                    'right' => 'lg:-mr-2 lg:right-1/4',
                },
            ])
            style="clip-path: polygon(0 0, 100% 0, 0 100%)"
            aria-hidden="true"></div>
    @endif

    @if (null !== ($header = $getHeader()))
        <div class="flex flex-col justify-between gap-4 px-4 py-5 md:flex-row md:items-center sm:px-6">
            <h3 class="text-lg font-bold text-gray-900">{{ $header }}</h3>

            @if (filled($actions = $getHeaderActions()))
                <div class="flex flex-wrap items-center gap-4">
                    @foreach ($actions as $action)
                        {{ $action }}
                    @endforeach
                </div>
            @endif
        </div>
    @endif

    <div class="flex-1 px-4 py-5 sm:px-6">
        {{ $getChildComponentContainer() }}
    </div>

    @if (null !== ($footer = $getFooter()))
        <div class="px-4 py-5 sm:px-6">
            {{ $footer }}
        </div>
    @endif

    <div class="flex flex-wrap items-center gap-4 p-6 bg-gray-50">
        <x-filament::modal
            display-classes="block"
            x-init="livewire = $wire.__instance"
            width="4xl">

            <x-slot name="trigger">
                <x-filament::link
                    x-on:click="open"
                    tag="button"
                    size="sm">
                    {{ __('recommendation.action.view_services') }}
                </x-filament::link>
            </x-slot>

            <x-slot name="header">
                <x-forms::modal.heading>
                    {{ data_get($getRecord(), 'title') }}
                </x-forms::modal.heading>
            </x-slot>

            {{ $getModalChildComponentContainer() }}
        </x-filament::modal>
    </div>

</div>
