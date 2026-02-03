<?php

declare(strict_types=1);

namespace App\Filament\Resources\Reports\Widgets;

use App\Enums\Report\Standard\Category;
use App\Enums\Report\Status;
use App\Enums\Report\Type;
use App\Filament\Resources\Reports\ReportResource;
use App\Models\Report;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\PaginationMode;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;
use Illuminate\Database\Eloquent\Builder;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;

class ReportsTableWidget extends TableWidget
{
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(fn (): Builder => ReportResource::getEloquentQuery())
            ->heading(__('report.header.list'))
            ->columns([
                TextColumn::make('created_at')
                    ->label(__('report.column.created_at'))
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('status')
                    ->label(__('report.column.status'))
                    ->badge(),

                TextColumn::make('type')
                    ->label(__('report.column.type')),

                TextColumn::make('period')
                    ->label(__('report.column.period')),

                TextColumn::make('category')
                    ->label(__('report.column.category'))
                    ->description(fn (Report $record) => $record->indicators()->map->getLabel()->join(', '))
                    ->wrap(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label(__('report.column.type'))
                    ->options(Type::class),

                SelectFilter::make('category')
                    ->label(__('report.column.category'))
                    ->options(Category::class),

                SelectFilter::make('status')
                    ->label(__('report.column.status'))
                    ->options(Status::class),

                DateRangeFilter::make('date_between'),
            ])
            ->headerActions([
                //
            ])
            ->recordActions([
                ViewAction::make()
                    ->url(fn (Report $record) => ReportResource::getUrl('view', ['record' => $record]))
                    ->iconButton(),
            ])
            ->defaultSort('id', 'desc')
            ->paginationMode(PaginationMode::Default);
    }
}
