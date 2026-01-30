<?php

declare(strict_types=1);

namespace App\Filament\Resources\Reports\Schemas;

use App\Livewire\ReportTable;
use App\Models\Report;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\EmptyState;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Livewire;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use function Filament\Support\generate_loading_indicator_html;

class ReportInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Section::make()
                    ->components([
                        Group::make()
                            ->inlineLabel()
                            ->maxWidth(Width::TwoExtraLarge)
                            ->schema([
                                TextEntry::make('category')
                                    ->label(__('report.column.category')),

                                TextEntry::make('type')
                                    ->label(__('report.column.type')),

                                TextEntry::make('period')
                                    ->label(__('report.column.period')),

                                TextEntry::make('created_at')
                                    ->label(__('report.column.created_at'))
                                    ->dateTime(),
                            ]),
                    ]),

                Group::make()
                    ->poll(fn (Report $record) => $record->isPending() ? '5s' : null)
                    ->components([
                        Group::make()
                            ->visible(fn (Report $record) => $record->isFinished() && $record->data->isNotEmpty())
                            ->components(function (Report $record): array {
                                return collect($record->data)
                                    ->map(
                                        fn (array $table, int $index) => Livewire::make(ReportTable::class)
                                            ->key("table.{$index}")
                                            ->data([
                                                'type' => $record->type,
                                                'title' => data_get($table, 'title'),
                                                'columns' => data_get($table, 'columns'),
                                                'data' => data_get($table, 'data'),
                                            ])
                                    )
                                    ->all();
                            }),

                        EmptyState::make(__('report.processing.title'))
                            ->description(__('report.processing.description'))
                            ->icon(fn () => generate_loading_indicator_html())
                            ->visible(fn (Report $record) => $record->isPending()),

                        EmptyState::make(__('report.failed.title'))
                            ->description(__('report.failed.description'))
                            ->icon(Heroicon::ExclamationTriangle)
                            ->iconColor('danger')
                            ->visible(fn (Report $record) => $record->isFailed()),

                        EmptyState::make(__('report.no-results.title'))
                            ->description(__('report.no-results.description'))
                            ->icon(Heroicon::QuestionMarkCircle)
                            ->iconColor('gray')
                            ->visible(fn (Report $record) => $record->isFinished() && $record->data->isEmpty()),
                    ]),

            ]);
    }
}
