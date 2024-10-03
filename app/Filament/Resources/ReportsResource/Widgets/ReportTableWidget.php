<?php

declare(strict_types=1);

namespace App\Filament\Resources\ReportResource\Widgets;

use App\Enums\Report\Standard\Category;
use App\Enums\Report\Status;
use App\Enums\Report\Type;
use App\Filament\Filters\DateRangeFilter;
use App\Filament\Resources\ReportResource;
use App\Filament\Tables\Columns\BadgeColumn;
use App\Filament\Tables\Columns\TextColumn;
use App\Models\Report;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Filters\SelectFilter;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class ReportTableWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected function getTableQuery(): Builder
    {
        return ReportResource::getEloquentQuery();
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('created_at')
                ->label(__('report.column.created_at'))
                ->formatStateUsing(fn (Report $record) => $record->created_at->toFormattedDateTime())
                ->extraHeaderAttributes(['class' => 'w-1'])
                ->sortable(),

            TextColumn::make('type')
                ->label(__('report.column.type'))
                ->enum(Type::options())
                ->extraHeaderAttributes(['class' => 'w-1']),

            TextColumn::make('category')
                ->label(__('report.column.category'))
                ->enum(Category::options())
                ->description(function (Report $record) {
                    // return $record->category->description;
                }),

            BadgeColumn::make('status')
                ->label(__('report.column.status'))
                ->enum(Status::options())
                ->colors(Status::flipColors()),

            TextColumn::make('period')
                ->label(__('report.column.period')),
        ];
    }

    protected function getTableFilters(): array
    {
        return [
            SelectFilter::make('type')
                ->label(__('report.column.type'))
                ->options(Type::options()),

            DateRangeFilter::make('date_between'),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            ViewAction::make()
                ->url(fn (Report $record) => ReportResource::getUrl('view', $record))
                ->iconButton(),
        ];
    }

    protected function getDefaultTableSortColumn(): ?string
    {
        return 'created_at';
    }

    protected function getDefaultTableSortDirection(): ?string
    {
        return 'desc';
    }

    // protected function getTablePollingInterval(): ?string
    // {
    //     return '5s';
    // }
}
