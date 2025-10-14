<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Resources\Interventions\Tables;

use App\Enums\Intervention\Status;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class InterventionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query): Builder {
                return $query
                    ->withCount([
                        'interventions',
                        'interventions as realized_interventions_count' => fn (Builder $query) => $query->onlyRealized(),
                    ]);
            })
            ->columns([
                TextColumn::make('id')
                    ->label(__('field.id'))
                    ->prefix('#'),

                TextColumn::make('name')
                    ->label(__('field.service_name'))
                    ->wrap(),

                TextColumn::make('vulnerability.name')
                    ->label(__('field.vulnerability'))
                    ->toggleable()
                    ->wrap(),

                TextColumn::make('type')
                    ->label(__('field.type')),

                TextColumn::make('status')
                    ->label(__('field.status'))
                    ->badge(),

                TextColumn::make('services')
                    ->label(__('field.services_realized'))
                    ->alignEnd(),

            ])
            ->filters([
                SelectFilter::make('type')
                    ->label(__('field.type'))
                    ->multiple(),

                SelectFilter::make('status')
                    ->label(__('field.status'))
                    ->options(Status::options())
                    ->multiple(),

                SelectFilter::make('vulnerability')
                    ->label(__('field.vulnerability'))
                    ->relationship('vulnerability', 'name')
                    ->searchable()
                    ->multiple()
                    ->preload(),
            ])
            ->recordActions([
                ViewAction::make()
                    ->iconButton(),
            ])
            ->defaultSort('id', 'desc');
    }
}
