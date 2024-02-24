<?php

declare(strict_types=1);

namespace App\Filament\Resources\CommunityActivityResource\Pages;

use App\Contracts\Pages\WithTabs;
use App\Enums\CommunityActivityType;
use App\Filament\Filters\DateRangeFilter;
use App\Filament\Resources\CommunityActivityResource;
use App\Filament\Resources\CommunityActivityResource\Concerns;
use App\Filament\Tables\Columns\TextColumn;
use App\Models\CommunityActivity;
use Filament\Resources\Pages\ManageRecords;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

class ManageAdministrativeActivities extends ManageRecords implements WithTabs
{
    use Concerns\HasActions;
    use Concerns\HasEmptyState;
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

                TextColumn::make('county.name')
                    ->label(__('field.county'))
                    ->size('sm')
                    ->sortable()
                    ->toggleable()
                    ->visible(fn () => auth()->user()->isAdmin()),

            ])
            ->filters([
                DateRangeFilter::make('date_between'),

                SelectFilter::make('county_id')
                    ->label(__('field.county'))
                    ->relationship('county', 'name')
                    ->visible(fn () => auth()->user()->isAdmin()),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->form(CommunityActivityResource::getAdministrativeViewFormSchema())
                    ->modalHeading(fn (CommunityActivity $record) => $record->title)
                    ->iconButton(),

                Tables\Actions\EditAction::make()
                    ->form(CommunityActivityResource::getAdministrativeEditFormSchema())
                    ->modalHeading(fn (CommunityActivity $record) => $record->title)
                    ->iconButton(),

                Tables\Actions\DeleteAction::make()
                    ->modalHeading(fn (CommunityActivity $record) => $record->title)
                    ->iconButton(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->form(CommunityActivityResource::getAdministrativeEditFormSchema())
                    ->using(function (array $data) {
                        $data['type'] = CommunityActivityType::ADMINISTRATIVE;

                        return CommunityActivity::create($data);
                    })
                    ->label(__('community_activity.action.create_administrative'))
                    ->modalHeading(__('community_activity.action.create_administrative'))
                    ->disableCreateAnother(),
            ])
            ->defaultSort('id', 'desc');
    }
}
