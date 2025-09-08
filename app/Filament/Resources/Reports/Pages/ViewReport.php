<?php

declare(strict_types=1);

namespace App\Filament\Resources\Reports\Pages;

use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Group;
use App\Filament\Resources\Reports\ReportResource;
use App\Filament\Resources\Reports\Actions\ExportAction;
use App\Forms\Components\ReportContent;
use App\Forms\Components\Value;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\ViewRecord;

class ViewReport extends ViewRecord
{
    protected static string $resource = ReportResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()
                ->record($this->getRecord()),

            DeleteAction::make(),
        ];
    }

    public function getTitle(): string
    {
        return $this->getRecord()->title;
    }

    protected function getFormSchema(): array
    {
        return [
            Section::make()
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
