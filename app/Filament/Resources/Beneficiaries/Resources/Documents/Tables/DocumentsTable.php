<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Resources\Documents\Tables;

use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DocumentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('created_at')
                    ->label(__('field.date'))
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('title')
                    ->label(__('field.document_title'))
                    ->wrap()
                    ->sortable()
                    ->searchable()
                    ->limit(),

                TextColumn::make('type')
                    ->label(__('field.document_type')),

                TextColumn::make('notes')
                    ->label(__('field.notes'))
                    ->searchable()
                    ->wrap()
                    ->limit(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make()
                    ->iconButton(),
            ])
            ->defaultSort('id', 'desc');
    }
}
