<div
    {{ $attributes->class([
        'filament-brand text-xl font-bold tracking-tight',
        'dark:text-white' => config('filament.dark_mode'),
    ]) }}>
    <svg viewBox="0 0 126 50" class="h-10">
        <title>{{ config('filament.brand') }}</title>
        <path clip-rule="evenodd"
            d="m0 22.6419v-8.707l8.43553-9.9349h7.24927l7.302 9.4605 7.3547-9.4605h7.2493l8.4092 9.9628v8.707l-22.9868 23.3302zm3.24241-7.3675v5.8884l19.77079 20.093 19.718-20.093v-5.9163l-6.6429-7.81394h-4.1915l-8.91 11.41394-8.8573-11.41394h-4.21775z"
            fill-rule="evenodd" />
        <path
            d="m62.64 36.5 5.408-21.92h7.072l5.44 21.92h-3.584l-1.184-4.704h-8.416l-1.184 4.704zm8.16-18.944-2.72 11.104h7.008l-2.688-11.104zm12.8843 18.944v-21.92h6.176l4.896 17.12 4.896-17.12h6.2077v21.92h-3.584v-17.984h-.48l-5.1837 17.088h-3.712l-5.184-17.088h-.48v17.984zm34.5477.352c-3.2 0-5.376-.8853-6.528-2.656-1.131-1.7707-1.696-4.6827-1.696-8.736s.576-6.9333 1.728-8.64c1.152-1.728 3.317-2.592 6.496-2.592 1.898 0 3.989.2667 6.272.8l-.128 2.88c-1.92-.3413-3.84-.512-5.76-.512s-3.222.576-3.904 1.728c-.683 1.1307-1.024 3.2747-1.024 6.432 0 3.136.33 5.28.992 6.432.661 1.1307 1.952 1.696 3.872 1.696s3.861-.16 5.824-.48l.096 2.944c-2.198.4693-4.278.704-6.24.704z" />
    </svg>
</div>
