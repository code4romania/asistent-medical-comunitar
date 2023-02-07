<div
    x-data="{
        error: undefined,
        state: @js((bool) $getState()),
        isLoading: false
    }"
    x-init="$watch('state', () => $refs.button.dispatchEvent(new Event('change')))"
    {{ $attributes->merge($getExtraAttributes())->class(['filament-tables-toggle-column']) }}
>
    <button
        role="switch"
        aria-checked="false"
        x-bind:aria-checked="state.toString()"
        x-on:click="! isLoading && (state = ! state)"
        x-ref="button"
        x-on:change="
            isLoading = true
            response = await $wire.updateTableColumnState(@js($getName()), @js($recordKey), state)
            error = response?.error ?? undefined
            isLoading = false
        "
        x-tooltip="error"
        x-bind:class="{
            'opacity-70 pointer-events-none': isLoading,
            '{{ match ($getOnColor()) {
                'danger' => 'bg-danger-500',
                'secondary' => 'bg-gray-500',
                'success' => 'bg-success-500',
                'warning' => 'bg-warning-500',
                default => 'bg-primary-600',
            } }}': state,
            '{{ match ($getOffColor()) {
                'danger' => 'bg-danger-500',
                'primary' => 'bg-primary-500',
                'success' => 'bg-success-500',
                'warning' => 'bg-warning-500',
                default => 'bg-gray-200',
            } }} @if (config('forms.dark_mode')) dark:bg-white/10 @endif':
                !state,
        }"
        {!! $isDisabled() ? 'disabled' : null !!}
        type="button"
        class="relative inline-flex h-6 ml-4 transition-colors duration-200 ease-in-out border-2 border-transparent rounded-full cursor-pointer shrink-0 w-11 focus:outline-none focus:ring-1 focus:ring-offset-1 focus:ring-primary-500 disabled:opacity-50 disabled:cursor-not-allowed disabled:pointer-events-none"
    >
        <span
            class="relative inline-block w-5 h-5 transition duration-200 ease-in-out transform bg-white rounded-full shadow pointer-events-none ring-0"
            x-bind:class="{
                'translate-x-5 rtl:-translate-x-5': state,
                'translate-x-0': !state,
            }"
        >
            <span
                class="absolute inset-0 flex items-center justify-center w-full h-full transition-opacity"
                aria-hidden="true"
                x-bind:class="{
                    'opacity-0 ease-out duration-100': state,
                    'opacity-100 ease-in duration-200': !state,
                }"
            >
                @if ($hasOffIcon())
                    <x-dynamic-component
                        :component="$getOffIcon()"
                        :class="\Illuminate\Support\Arr::toCssClasses([
                            'h-3 w-3',
                            match ($getOffColor()) {
                                'danger' => 'text-danger-500',
                                'primary' => 'text-primary-500',
                                'success' => 'text-success-500',
                                'warning' => 'text-warning-500',
                                default => 'text-gray-400',
                            },
                        ])"
                    />
                @endif
            </span>

            <span
                class="absolute inset-0 flex items-center justify-center w-full h-full transition-opacity"
                aria-hidden="true"
                x-bind:class="{
                    'opacity-100 ease-in duration-200': state,
                    'opacity-0 ease-out duration-100': !state,
                }"
            >
                @if ($hasOnIcon())
                    <x-dynamic-component
                        :component="$getOnIcon()"
                        x-cloak
                        :class="\Illuminate\Support\Arr::toCssClasses([
                            'h-3 w-3',
                            match ($getOnColor()) {
                                'danger' => 'text-danger-500',
                                'secondary' => 'text-gray-400',
                                'success' => 'text-success-500',
                                'warning' => 'text-warning-500',
                                default => 'text-primary-500',
                            },
                        ])"
                    />
                @endif
            </span>
        </span>
    </button>
</div>
