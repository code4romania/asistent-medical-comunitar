<?php

declare(strict_types=1);

namespace App\Filament\Resources\Vacations\Tables;

use App\Models\County;
use App\Models\Vacation;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class VacationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('field.id'))
                    ->prefix('#')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('user.full_name')
                    ->label(__('field.user'))
                    ->toggleable(fn (TextColumn $column) => ! $column->isHidden())
                    ->description(fn (Vacation $record): string => $record->user->role->getLabel())
                    ->hidden(fn (): bool => auth()->user()->isNurseOrMediator()),

                TextColumn::make('user.activityCounty.name')
                    ->label(__('field.county'))
                    ->toggleable(fn (TextColumn $column) => ! $column->isHidden())
                    ->visible(fn () => auth()->user()->isAdmin()),

                TextColumn::make('type')
                    ->label(__('field.type'))
                    ->limit()
                    ->sortable()
                    ->toggleable()
                    ->grow(),

                TextColumn::make('start_date')
                    ->label(__('field.start_date'))
                    ->size('sm')
                    ->date()
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('end_date')
                    ->label(__('field.end_date'))
                    ->size('sm')
                    ->date()
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('county')
                    ->label(__('field.county'))
                    ->options(County::cachedList())
                    ->query(function (Builder $query, array $data) {
                        if (blank($data['value'])) {
                            return $query;
                        }

                        $query->whereRelation('user.activityCounty', 'counties.id', $data['value']);
                    })
                    ->visible(fn () => auth()->user()->isAdmin()),

                SelectFilter::make('user')
                    ->label(__('field.user'))
                    ->relationship('user', 'full_name', fn (Builder $query) => $query->onlyNursesAndMediators())
                    ->multiple()
                    ->hidden(fn (): bool => auth()->user()->isNurseOrMediator()),
            ])
            ->recordActions([
                ViewAction::make()
                    ->iconButton(),

                EditAction::make()
                    ->iconButton(),

                DeleteAction::make()
                    ->iconButton(),
            ])
            ->emptyStateHeading(fn (Table $table) => ! $table->hasAlteredQuery() ? __('vacation.empty.title') : null)
            ->emptyStateDescription(fn (Table $table) => ! $table->hasAlteredQuery() ? __('vacation.empty.description') : null)
            ->defaultSort('id', 'desc');
    }
}
