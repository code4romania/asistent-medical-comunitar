<?php

declare(strict_types=1);

namespace App\Filament\Resources\Households\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class HouseholdsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('field.household'))
                    // ->description(__('field.household'), position: 'above')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('families.name')
                    ->label(__('field.families_count'))
                    // ->description(__('field.families_count'), position: 'above')
                    // ->counts('families')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                TextColumn::make('beneficiaries.full_name')
                    ->label(__('field.beneficiaries_count'))
                    // ->description(__('field.beneficiaries_count'), position: 'above')
                    // ->counts('beneficiaries')
                    ->searchable()
                    ->sortable()
                    ->wrap(),
            ])
            ->filters([
                //
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
