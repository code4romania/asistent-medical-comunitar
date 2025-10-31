<?php

declare(strict_types=1);

namespace App\Filament\Resources\Profiles\Tables;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CoursesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('end_date')
                    ->label(__('field.year'))
                    ->date('Y')
                    ->sortable(),

                TextColumn::make('provider')
                    ->label(__('field.course_provider'))
                    ->sortable(),

                TextColumn::make('name')
                    ->label(__('field.course_name'))
                    ->limit(30)
                    ->sortable(),

                TextColumn::make('type')
                    ->label(__('field.course_type')),

                TextColumn::make('credits')
                    ->label(__('field.course_credits'))
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make()
                    ->label(__('course.action.create')),
            ])
            ->recordActions([
                ViewAction::make()
                    ->iconButton(),

                EditAction::make()
                    ->label(__('course.action.edit'))
                    ->iconButton(),

                DeleteAction::make()
                    ->label(__('course.action.delete'))
                    ->iconButton(),
            ])
            ->defaultSort('end_date', 'desc');
    }
}
