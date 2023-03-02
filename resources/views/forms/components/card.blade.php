<div
    {!! $getId() ? "id=\"{$getId()}\"" : null !!}
    {{ $attributes->merge($getExtraAttributes())->class([
            'filament-forms-card-component bg-white rounded-xl border',
            'dark:border-gray-600 dark:bg-gray-800' => config('forms.dark_mode'),
        ]) }}
>

    @if (null !== ($header = $getHeader()))
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-lg font-bold text-gray-900">{{ $header }}</h3>
        </div>
    @endif

    <div class="px-4 py-5 sm:px-6">
        {{ $getChildComponentContainer() }}
    </div>

    @if (null !== ($footer = $getFooter()))
        <div class="px-4 py-5 sm:px-6">
            {{ $footer }}
        </div>
    @endif
</div>
