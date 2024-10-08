<?php

declare(strict_types=1);

namespace App\Filament\Forms\Components;

use App\Models\Report;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\View;

class ReportContent extends Component
{
    protected string $view = 'components.forms.report.content';

    public static function make(): static
    {
        $static = app(static::class);
        $static->configure();

        return $static;
    }

    public function shouldPoll(): bool
    {
        return $this->evaluate(fn (Report $record) => $record->isPending());
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->schema([
            $this->emptyState(),
            $this->tables(),
        ]);
    }

    protected function tables(): Group
    {
        return Group::make()
            ->visible(fn (Report $record) => $record->isFinished() && $record->data->isNotEmpty())
            ->schema(function (Report $record) {
                $component = $record->isList()
                    ? 'components.reports.table.list'
                    : 'components.reports.table.statistic';

                return collect($record->data)
                    ->map(
                        fn (array $table) => Card::make()
                            ->header(data_get($table, 'title'))
                            ->schema([
                                View::make('vendor.tables.components.empty-state.index')
                                    ->visible(blank(data_get($table, 'data')))
                                    ->viewData([
                                        'icon' => 'heroicon-o-x',
                                        'heading' => __('report.no-results.title'),
                                        'description' => __('report.no-results.description'),
                                    ]),

                                View::make($component)
                                    ->visible(filled(data_get($table, 'data')))
                                    ->viewData([
                                        'columns' => data_get($table, 'columns'),
                                        'data' => data_get($table, 'data'),
                                    ]),
                            ])
                    )
                    ->all();
            });
    }

    protected function emptyState(): Card
    {
        return Card::make()
            ->hidden(fn (Report $record) => $record->isFinished() && $record->data->isNotEmpty())
            ->schema([
                View::make('vendor.tables.components.empty-state.index')
                    ->visible(fn (Report $record) => $record->isPending())
                    ->viewData([
                        'icon' => 'filament-support::loading-indicator',
                        'heading' => __('report.processing.title'),
                        'description' => __('report.processing.description'),
                        'spin' => true,
                    ]),

                View::make('vendor.tables.components.empty-state.index')
                    ->visible(fn (Report $record) => $record->isFailed())
                    ->viewData([
                        'icon' => 'heroicon-s-exclamation',
                        'iconClass' => 'text-danger-600',
                        'heading' => __('report.failed.title'),
                        'description' => __('report.failed.description'),
                    ]),

                View::make('vendor.tables.components.empty-state.index')
                    ->visible(fn (Report $record) => $record->isFinished() && $record->data->isEmpty())
                    ->viewData([
                        'icon' => 'icon-clipboard',
                        'heading' => __('report.no-results.title'),
                        'description' => __('report.no-results.description'),
                    ]),
            ]);
    }
}
