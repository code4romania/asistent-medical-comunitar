<?php

declare(strict_types=1);

namespace App\Filament\Resources\Reports;

use App\Filament\Resources\Reports\Pages\GenerateStandardReport;
use App\Filament\Resources\Reports\Pages\ViewReport;
use App\Filament\Resources\Reports\Schemas\ReportForm;
use App\Filament\Resources\Reports\Schemas\ReportInfolist;
use App\Models\Report;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;

class ReportResource extends Resource
{
    protected static ?string $model = Report::class;

    protected static ?int $navigationSort = 5;

    public static function getModelLabel(): string
    {
        return __('report.label.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('report.label.plural');
    }

    public static function form(Schema $schema): Schema
    {
        return ReportForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ReportInfolist::configure($schema);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => GenerateStandardReport::route('/'),
            'view' => ViewReport::route('/{record}'),
        ];
    }
}
