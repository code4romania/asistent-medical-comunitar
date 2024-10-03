<?php

declare(strict_types=1);

namespace App\Filament\Resources\ReportResource\Pages;

use App\Filament\Forms\Components\Card;
use App\Filament\Forms\Components\ReportContent;
use App\Filament\Forms\Components\Value;
use App\Filament\Resources\ReportResource;
use Filament\Forms\Components\Group;
use Filament\Pages\Actions\Action;
use Filament\Pages\Actions\DeleteAction;
use Filament\Resources\Pages\ViewRecord;

class ViewReport extends ViewRecord
{
    protected static string $resource = ReportResource::class;

    protected function getActions(): array
    {
        return [
            Action::make('export')
                ->label(__('report.action.export'))
                ->icon('heroicon-o-download')
                ->color('secondary'),

            DeleteAction::make(),
        ];
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
