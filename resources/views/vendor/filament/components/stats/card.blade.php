@props([
    'chart' => null,
    'chartColor' => null,
    'color' => null,
    'icon' => null,
    'description' => null,
    'descriptionColor' => null,
    'descriptionIcon' => null,
    'descriptionIconPosition' => 'after',
    'flat' => false,
    'label' => null,
    'tag' => 'div',
    'value' => null,
    'extraAttributes' => [],
])

<{!! $tag !!}
    {{ $attributes->merge($extraAttributes)->class([
            'filament-stats-card relative overflow-hidden rounded-lg p-4 bg-white shadow',
            'dark:bg-gray-800' => config('filament.dark_mode'),
            'pb-6' => $chart !== null,
        ]) }}
>
    <div class="flex gap-4 items-start">
        @if ($icon)
            <div class="flex items-center justify-center w-12 h-12 rounded-md bg-primary-500 shrink-0">
                <x-dynamic-component
                    :component="$icon"
                    class="h-6 w-6 text-white"
                />
            </div>
        @endif

        <div>
            <p class="truncate text-sm font-medium text-gray-500">{{ $label }}</p>

            <div class="flex items-baseline gap-2">
                <div class="text-2xl font-semibold text-gray-900">{{ $value }}</div>

                @if ($description)
                    <div @class([
                        'flex items-center space-x-1 rtl:space-x-reverse text-sm font-medium',
                        match ($descriptionColor) {
                            'danger' => 'text-danger-600',
                            'primary' => 'text-primary-600',
                            'success' => 'text-success-600',
                            'warning' => 'text-warning-600',
                            default => 'text-gray-600',
                        },
                    ])>
                        @if ($descriptionIcon && $descriptionIconPosition === 'before')
                            <x-dynamic-component
                                :component="$descriptionIcon"
                                class="w-4 h-4"
                            />
                        @endif

                        <span>{{ $description }}</span>

                        @if ($descriptionIcon && $descriptionIconPosition === 'after')
                            <x-dynamic-component
                                :component="$descriptionIcon"
                                class="w-4 h-4"
                            />
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if ($chart)
        <div
            x-title="filament-stats-card-chart"
            x-data="{
                chart: null,

                labels: {{ json_encode(array_keys($chart)) }},
                values: {{ json_encode(array_values($chart)) }},

                init: function() {
                    this.chart ? this.updateChart() : this.initChart()
                },

                initChart: function() {
                    return this.chart = new Chart(this.$refs.canvas, {
                        type: 'line',
                        data: {
                            labels: this.labels,
                            datasets: [{
                                data: this.values,
                                backgroundColor: getComputedStyle($refs.backgroundColorElement).color,
                                borderColor: getComputedStyle($refs.borderColorElement).color,
                                borderWidth: 2,
                                fill: 'start',
                                tension: 0.5,
                            }],
                        },
                        options: {
                            elements: {
                                point: {
                                    radius: 0,
                                },
                            },
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false,
                                },
                            },
                            scales: {
                                x: {
                                    display: false,
                                },
                                y: {
                                    display: false,
                                },
                            },
                            tooltips: {
                                enabled: false,
                            },
                        },
                    })
                },

                updateChart: function() {
                    this.chart.data.labels = this.labels
                    this.chart.data.datasets[0].data = this.values
                    this.chart.update()
                },
            }"
            class="absolute bottom-0 inset-x-0 overflow-hidden"
        >
            <canvas
                wire:ignore
                x-ref="canvas"
                class="h-6"
            >
                <span
                    x-ref="backgroundColorElement"
                    @class([
                        match ($chartColor) {
                            'danger' => \Illuminate\Support\Arr::toCssClasses([
                                'text-danger-50',
                                'dark:text-danger-700' => config('filament.dark_mode'),
                            ]),
                            'primary' => \Illuminate\Support\Arr::toCssClasses([
                                'text-primary-50',
                                'dark:text-primary-700' => config('filament.dark_mode'),
                            ]),
                            'success' => \Illuminate\Support\Arr::toCssClasses([
                                'text-success-50',
                                'dark:text-success-700' => config('filament.dark_mode'),
                            ]),
                            'warning' => \Illuminate\Support\Arr::toCssClasses([
                                'text-warning-50',
                                'dark:text-warning-700' => config('filament.dark_mode'),
                            ]),
                            default => \Illuminate\Support\Arr::toCssClasses([
                                'text-gray-50',
                                'dark:text-gray-700' => config('filament.dark_mode'),
                            ]),
                        },
                    ])
                ></span>

                <span
                    x-ref="borderColorElement"
                    @class([
                        match ($chartColor) {
                            'danger' => 'text-danger-400',
                            'primary' => 'text-primary-400',
                            'success' => 'text-success-400',
                            'warning' => 'text-warning-400',
                            default => 'text-gray-400',
                        },
                    ])
                ></span>
            </canvas>
        </div>
    @endif
    </{!! $tag !!}>
