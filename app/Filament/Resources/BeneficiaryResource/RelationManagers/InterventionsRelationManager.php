<?php

declare(strict_types=1);

namespace App\Filament\Resources\BeneficiaryResource\RelationManagers;

use App\Models\Intervention\Intervention;
use Closure;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Contracts\Support\Htmlable;

class InterventionsRelationManager extends RelationManager
{
    protected static string $relationship = 'interventions';

    protected function getTableHeading(): string | Htmlable | Closure | null
    {
        return null;
    }

    protected static function getPluralModelLabel(): string
    {
        return __('intervention.label.plural');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('field.id'))
                    ->prefix('#')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('service.name')
                    ->label(__('field.interventions'))
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('status')
                    ->label(__('field.status'))
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('services')
                    ->label(__('field.services_offered'))
                    ->sortable()
                    ->toggleable(),

                // TextColumn::make('causer.full_name')
                //     ->label(__('field.interventions'))
                //     ->default(__('activity.no_causer'))
                //     ->searchable()
                //     ->toggleable()
                //     ->sortable(),

                // TextColumn::make('log_name')
                //     ->label(__('field.services_offered'))
                //     // ->formatStateUsing(fn (Intervention $record) => __("activity.beneficiary.{$record->log_name}"))
                //     ->toggleable()
                //     ->sortable(),

                // TextColumn::make('event')
                //     ->label(__('field.appointments'))
                //     ->formatStateUsing(fn (Intervention $record) => __("activity.event.{$record->event}"))
                //     ->toggleable()
                //     ->sortable(),
            ])
            ->filters([
                //
            ])
            ->bulkActions([])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->icon(null),
            ])
            ->defaultSort('created_at', 'DESC');
    }

    protected function getTableEmptyStateIcon(): ?string
    {
        return 'icon-empty-state';
    }
}
