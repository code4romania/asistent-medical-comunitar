<?php

declare(strict_types=1);

namespace App\Filament\Resources\CommunityActivityResource\Pages;

use App\Contracts\Pages\WithTabs;
use App\Filament\Filters\DateRangeFilter;
use App\Filament\Resources\CommunityActivityResource;
use App\Filament\Resources\CommunityActivityResource\Concerns;
use App\Filament\Tables\Columns\TextColumn;
use Filament\Resources\Pages\ManageRecords;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;

class ManageAdministrativeActivities extends ManageRecords implements WithTabs
{
    use Concerns\HasActions;
    use Concerns\HasTabs;

    protected static string $resource = CommunityActivityResource::class;

    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()->onlyAdministrativeActivities();
    }

    protected function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('field.id'))
                    ->prefix('#')
                    ->size('sm')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('name')
                    ->label(__('field.activity'))
                    ->size('sm')
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('date')
                    ->label(__('field.date'))
                    ->size('sm')
                    ->date()
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('outside_working_hours')
                    ->label(__('field.hour'))
                    ->formatStateUsing(fn ($record) => $record->hour)
                    ->size('sm')
                    ->sortable()
                    ->toggleable(),

            ])
            ->filters([
                DateRangeFilter::make('date_between'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->form(CommunityActivityResource::getAdministrativeViewFormSchema())
                    ->recordTitle(__('community_activity.type.administrative'))
                    ->iconButton(),

                Tables\Actions\EditAction::make()
                    ->form(CommunityActivityResource::getAdministrativeEditFormSchema())
                    ->recordTitle(__('community_activity.type.administrative'))
                    ->iconButton(),

                Tables\Actions\DeleteAction::make()
                    ->recordTitle(__('community_activity.type.administrative'))
                    ->iconButton(),
            ])
            ->defaultSort('id', 'desc');
    }
}
