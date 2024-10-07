<?php

declare(strict_types=1);

namespace App\Filament\Resources\ReportResource\Pages;

use App\Filament\Forms\Components\Card;
use App\Filament\Forms\Components\ReportContent;
use App\Filament\Forms\Components\Value;
use App\Filament\Resources\ReportResource;
use App\Filament\Resources\ReportResource\Actions\ExportAction;
use Filament\Forms\Components\Group;
use Filament\Pages\Actions\DeleteAction;
use Filament\Resources\Pages\ViewRecord;

class ViewReport extends ViewRecord
{
    protected static string $resource = ReportResource::class;

    protected function getActions(): array
    {
        return [

            ExportAction::make()
                ->record($this->getRecord()),

            DeleteAction::make(),
        ];
    }

    protected function getTitle(): string
    {
        return $this->getRecord()->title;
    }

    protected function getFormSchema(): array
    {
        return [
            Card::make()
                ->schema([
                    Group::make()
                        ->inlineLabel()
                        ->maxWidth('2xl')
                        ->schema([
                            Value::make('category')
                                ->label(__('report.column.category')),

                            Value::make('type')
                                ->label(__('report.column.type')),

                            Value::make('period')
                                ->label(__('report.column.period')),

                            Value::make('created_at')
                                ->label(__('report.column.created_at'))
                                ->withTime(),
                        ]),
                ]),

            ReportContent::make(),
        ];
    }
}
