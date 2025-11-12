<?php

declare(strict_types=1);

namespace App\Filament\Resources\Recommendations\Tables;

use App\Models\Recommendation;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class RecommendationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('field.id'))
                    ->prefix('#')
                    ->toggleable()
                    ->searchable()
                    ->sortable(),

                TextColumn::make('title')
                    ->label(__('field.recommendation_title'))
                    ->searchable()
                    ->toggleable()
                    ->sortable(),

                TextColumn::make('vulnerabilities.name_with_category')
                    ->label(__('field.recommendation_vulnerabilities'))
                    ->badge()
                    ->wrap(),

                TextColumn::make('services.name')
                    ->label(__('field.recommendation_services'))
                    ->badge()
                    ->wrap(),
            ])
            ->filters([
                SelectFilter::make('vulnerabilities')
                    ->label(__('field.recommendation_vulnerabilities'))
                    ->relationship('vulnerabilities', 'name')
                    ->multiple(),

                SelectFilter::make('services')
                    ->label(__('field.recommendation_services'))
                    ->relationship('services', 'name')
                    ->multiple(),
            ])
            ->recordActions([
                ViewAction::make()
                    ->modalHeading(fn (Recommendation $record) => \sprintf(
                        '#%d - %s',
                        $record->id,
                        $record->title
                    ))
                    ->iconButton(),

                EditAction::make()
                    ->iconButton(),

                DeleteAction::make()
                    ->iconButton(),
            ])
            ->defaultSort('id', 'desc');
    }
}
