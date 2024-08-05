<?php

declare(strict_types=1);

namespace App\Filament\Forms\Components;

use App\Filament\Resources\ReportResource\Actions\SaveReportAction;
use App\Models\Report;
use Filament\Forms\Components\Group;
use Filament\Pages\Actions\Action;

class ReportCard extends Card
{
    public static function make(array $schema = []): static
    {
        $static = app(static::class, ['schema' => $schema]);
        $static->configure();

        return $static;
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->hidden(fn (?Report $record) => \is_null($record));

        $this->header(function (?Report $record) {
            if ($this->isHidden()) {
                return null;
            }

            return collect([
                $record->category,
                $record->title,
            ])
                ->filter()
                ->implode(' / ');
        });

        $this->headerActions(function (?Report $record) {
            if ($this->isHidden()) {
                return [];
            }

            $actions = [
                Action::make('export')
                    ->label(__('report.action.export'))
                    ->icon('heroicon-o-download')
                    ->color('secondary')
                    ->record($record)
                    ->disabled(),
            ];

            if ($this->getContainer()->getContext() === 'generate') {
                $actions[] = SaveReportAction::make();
            }

            return $actions;
        });

        $this->schema([
            Group::make()
                ->inlineLabel()
                ->maxWidth('2xl')
                ->schema([

                    Value::make('category')
                        ->label(__('report.column.category')),

                    Value::make('title')
                        ->label(__('report.column.title')),

                    Value::make('type')
                        ->label(__('report.column.type')),

                    Value::make('period')
                        ->label(__('report.column.period')),

                    Value::make('created_at')
                        ->label(__('report.column.created_at'))
                        ->withTime(),

                ])
                ->visibleOn('view'),

            ReportTable::make(),
        ]);
    }
}
