<div
    {!! $getId() ? "id=\"{$getId()}\"" : null !!}
    {{ $attributes->merge($getExtraAttributes())->class([
            'filament-forms-card-component bg-white rounded-xl border',
            'dark:border-gray-600 dark:bg-gray-800' => config('forms.dark_mode'),
        ]) }}
>

    @if (null !== ($heading = $getHeading()))
        <div @class([
            'border-b px-4 py-5 sm:px-6 border-gray-200',
            'dark:border-gray-600' => config('forms.dark_mode'),
        ])>
            <h3 class="text-lg font-bold text-gray-900">{{ $heading }}</h3>
        </div>
    @endif

    <div class="px-4 py-5 sm:px-6">
        {{ $getChildComponentContainer() }}
    </div>
</div>
