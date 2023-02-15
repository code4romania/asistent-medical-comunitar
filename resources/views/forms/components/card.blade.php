<div
    {!! $getId() ? "id=\"{$getId()}\"" : null !!}
    {{ $attributes->merge($getExtraAttributes())->class([
            'filament-forms-card-component bg-white rounded-xl border',
            'dark:border-gray-600 dark:bg-gray-800' => config('forms.dark_mode'),
        ]) }}
>
    <div @class([
        'border-b p-6 border-gray-200',
        'dark:border-gray-600' => config('forms.dark_mode'),
    ])>
        <h3 class="text-lg font-bold text-gray-900">{{ $getHeading() }}</h3>
    </div>

    <div class="p-6">
        {{ $getChildComponentContainer() }}
    </div>
</div>
