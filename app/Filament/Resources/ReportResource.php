<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\ReportResource\Pages;
use App\Filament\Resources\ReportResource\Widgets\ReportTableWidget;
use App\Models\Report;
use Filament\Resources\Resource;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;

    protected static ?int $navigationSort = 5;

    protected static ?string $navigationIcon = 'heroicon-m-presentation-chart-line';

    public static function getModelLabel(): string
    {
        return __('report.label.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('report.label.plural');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\GenerateStandardReport::route('/'),
            // 'custom' => Pages\GenerateCustomReport::route('/generate'),
            'view' => Pages\ViewReport::route('/{record}'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            ReportTableWidget::class,
        ];
    }
}
