<?php

declare(strict_types=1);

namespace App\Filament\Forms\Components;

use App\Filament\Resources\ReportResource\Actions\SaveReportAction;
use App\Models\Report;
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

        $this->hidden(fn (?Report $record) => null === $record?->type);

        $this->header(function (?Report $record) {
            if ($this->isHidden()) {
                return null;
            }

            return $record->title;
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
            ReportTable::make(),
        ]);
    }
}
