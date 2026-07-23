<?php

declare(strict_types=1);

namespace App\Filament\Resources\Feedback\Tables;

use App\Models\County;
use App\Models\Feedback;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;

class FeedbackTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->with(['user', 'category', 'subcategory', 'county', 'city']))
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
                    ->description(fn (Feedback $record): string => $record->user->role->getLabel())
                    ->hidden(fn (): bool => auth()->user()->isNurseOrMediator()),

                TextColumn::make('category.name')
                    ->label(__('field.category'))
                    ->limit()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('subcategory.name')
                    ->label(__('field.subcategory'))
                    ->limit()
                    ->toggleable(),

                TextColumn::make('county.name')
                    ->label(__('field.county'))
                    ->hidden(fn (): bool => auth()->user()->isNurseOrMediator())
                    ->toggleable(),

                TextColumn::make('city.name')
                    ->label(__('field.city'))
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label(__('field.date'))
                    ->size('sm')
                    ->date()
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->label(__('field.category'))
                    ->relationship('category', 'name'),

                SelectFilter::make('subcategory')
                    ->label(__('field.subcategory'))
                    ->relationship('subcategory', 'name'),

                SelectFilter::make('county_id')
                    ->label(__('field.county'))
                    ->options(County::cachedList())
                    ->visible(fn (): bool => auth()->user()->isAdmin()),

                SelectFilter::make('user')
                    ->label(__('field.user'))
                    ->relationship('user', 'full_name', fn (Builder $query) => $query->onlyNursesAndMediators())
                    ->multiple()
                    ->hidden(fn (): bool => auth()->user()->isNurseOrMediator()),

                DateRangeFilter::make('created_at')
                    ->label(__('field.date')),
            ])
            ->recordActions([
                ViewAction::make()
                    ->iconButton(),

                EditAction::make()
                    ->iconButton(),

                DeleteAction::make()
                    ->iconButton(),
            ])
            ->defaultSort('id', 'desc');
    }
}
