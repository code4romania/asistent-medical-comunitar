<?php

declare(strict_types=1);

namespace App\Filament\Resources\Reports;

use App\Filament\Resources\Reports\Pages\GenerateStandardReport;
use App\Filament\Resources\Reports\Pages\ViewReport;
use App\Filament\Resources\ReportResource\Pages;
use App\Filament\Resources\Reports\Widgets\ReportTableWidget;
use App\Models\Report;
use Filament\Resources\Resource;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;

    protected static ?int $navigationSort = 5;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-m-presentation-chart-line';

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
            'index' => GenerateStandardReport::route('/'),
            // 'custom' => Pages\GenerateCustomReport::route('/generate'),
            'view' => ViewReport::route('/{record}'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            ReportTableWidget::class,
        ];
    }
}
