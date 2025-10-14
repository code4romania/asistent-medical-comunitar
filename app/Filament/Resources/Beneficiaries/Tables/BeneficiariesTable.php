<?php

declare(strict_types=1);

namespace App\Filament\Resources\Beneficiaries\Tables;

use App\Enums\Beneficiary\Status;
use App\Filament\Resources\Beneficiaries\Pages\ListBeneficiaries;
use App\Filament\Resources\Beneficiaries\Pages\ListOcasionalBeneficiaries;
use App\Models\Beneficiary;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class BeneficiariesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->withLocation())
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

                TextColumn::make('last_name_with_prior')
                    ->label(__('field.last_name'))
                    ->sortable(
                        query: fn (Builder $query, string $direction) => $query
                            ->orderBy('last_name', $direction)
                    )
                    ->searchable(
                        query: fn (Builder $query, string $search) => $query
                            ->where('last_name', 'like', "%{$search}%")
                            ->orWhere('prior_name', 'like', "%{$search}%")
                    )
                    ->toggleable(),

                TextColumn::make('cnp')
                    ->label(__('field.cnp'))
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('age')
                    ->label(__('field.age'))
                    ->toggleable(),

                TextColumn::make('city.name')
                    ->label(__('field.city'))
                    ->description(fn (Beneficiary $record) => $record->county?->name)
                    ->toggleable(),

                TextColumn::make('status')
                    ->label(__('field.status'))
                    ->badge()
                    ->hidden(fn (Page $livewire) => $livewire instanceof ListOcasionalBeneficiaries),

                TextColumn::make('type')
                    ->label(__('field.beneficiary_type'))
                    ->badge()
                    ->hidden(
                        fn (Page $livewire) => is_subclass_of($livewire, ListBeneficiaries::class)
                    ),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label(__('field.status'))
                    ->options(Status::options())
                    ->multiple(),
            ])
            ->recordActions([
                ViewAction::make()
                    ->iconButton(),
            ])
            ->defaultSort('id', 'desc');
    }
}
