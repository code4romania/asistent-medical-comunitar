<?php

declare(strict_types=1);

namespace App\Filament\Resources\Appointments\Tables;

use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class AppointmentsTable
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

                TextColumn::make('date')
                    ->label(__('field.date'))
                    ->date()
                    ->toggleable()
                    ->sortable(),

                TextColumn::make('interval')
                    ->label(__('field.interval_hours'))
                    ->toggleable(),

                TextColumn::make('beneficiary.id')
                    ->label(__('field.beneficiary_id'))
                    ->prefix('#')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('beneficiary.full_name')
                    ->label(__('field.beneficiary'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                // TextColumn::make('services')
                //     ->label(__('field.services'))
                //     ->toggleable(),

                TextColumn::make('interventions_count')
                    ->counts('interventions')
                    ->label(__('field.associated_interventions'))
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('location')
                    ->label(__('field.location'))
                    ->searchable()
                    ->toggleable(),
            ])
            ->filters([
                SelectFilter::make('beneficiary')
                    ->label(__('field.beneficiary'))
                    ->relationship('beneficiary', 'full_name')
                    ->placeholder(__('placeholder.all_beneficiaries'))
                    ->multiple(),
            ])
            ->recordActions([
                ViewAction::make()
                    ->iconButton(),
            ])
            ->emptyStateHeading(fn (Table $table) => ! $table->hasAlteredQuery() ? __('appointment.empty.title') : null)
            ->emptyStateDescription(fn (Table $table) => ! $table->hasAlteredQuery() ? __('appointment.empty.description') : null)
            ->defaultSort('id', 'desc');
    }
}
