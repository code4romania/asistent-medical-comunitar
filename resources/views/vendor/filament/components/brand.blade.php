<div
    {{ $attributes->class([
        'filament-brand text-xl font-bold tracking-tight',
        'dark:text-white' => config('filament.dark_mode'),
    ]) }}>
    @svg('logo', 'h-10')
</div>
