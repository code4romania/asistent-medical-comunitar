<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\Tables;

use App\Filament\Tables\Filters\UserStatusFilter;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class MediatorsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query): Builder {
                return $query
                    ->onlyMediators()
                    ->when(
                        auth()->user()->isCoordinator(),
                        fn (Builder $query): Builder => $query
                            ->activatesInCurrentUserCounty()
                    );
            })
            ->columns([
                TextColumn::make('id')
                    ->label(__('field.id'))
                    ->prefix('#')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('first_name')
                    ->label(__('field.first_name'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('last_name')
                    ->label(__('field.last_name'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('email')
                    ->label(__('field.email'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('activityCounty.name')
                    ->label(__('field.county'))
                    ->toggleable(),

                TextColumn::make('activityCities.formatted_name')
                    ->label(__('field.area'))
                    ->html()
                    ->wrap()
                    ->toggleable(),

                TextColumn::make('mediated_beneficiaries_count')
                    ->label(__('field.beneficiaries_count'))
                    ->counts('mediatedBeneficiaries')
                    ->alignRight()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('status')
                    ->label(__('field.status'))
                    ->badge()
                    ->toggleable(),
            ])
            ->filters([
                UserStatusFilter::make(),
            ])
            ->recordActions([
                ViewAction::make()
                    ->iconButton(),
            ])
            ->defaultSort('id', 'desc');
    }
}
