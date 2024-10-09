<?php

declare(strict_types=1);

namespace App\Filament\Resources\CommunityActivityResource\Pages;

use App\Contracts\Pages\WithTabs;
use App\Enums\CommunityActivity\Administrative;
use App\Enums\CommunityActivity\Type;
use App\Filament\Filters\DateRangeFilter;
use App\Filament\Resources\CommunityActivityResource;
use App\Filament\Resources\CommunityActivityResource\Concerns;
use App\Filament\Tables\Columns\TextColumn;
use App\Models\CommunityActivity;
use App\Models\County;
use Filament\Resources\Pages\ManageRecords;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;

class ManageAdministrativeActivities extends ManageRecords implements WithTabs
{
    use Concerns\HasActions;
    use Concerns\HasEmptyState;
    use Concerns\HasTabs;

    protected static string $resource = CommunityActivityResource::class;

    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()
            ->whereAdministrativeActivity()
            ->with('nurse.activityCities');
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

                TextColumn::make('nurse.full_name')
                    ->label(__('field.nurse'))
                    ->size('sm')
                    ->sortable()
                    ->toggleable()
                    ->hidden(fn () => auth()->user()->isNurse()),

                TextColumn::make('nurse.activityCounty.name')
                    ->label(__('field.county'))
                    ->size('sm')
                    ->toggleable()
                    ->visible(fn () => auth()->user()->isAdmin())
                    ->hidden(fn () => auth()->user()->isNurse()),

                TextColumn::make('nurse.activitiyCities')
                    ->label(__('field.cities'))
                    ->size('sm')
                    ->toggleable()
                    ->formatStateUsing(
                        fn (CommunityActivity $record) => $record
                            ->nurse
                            ?->activityCities
                            ->pluck('name')
                            ->join(', ')
                    )
                    ->hidden(fn () => auth()->user()->isNurse()),

                TextColumn::make('subtype')
                    ->label(__('field.type'))
                    ->enum(Administrative::options())
                    ->size('sm')
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

                SelectFilter::make('subtype')
                    ->label(__('field.type'))
                    ->options(Administrative::options())
                    ->multiple(),

                SelectFilter::make('nurse')
                    ->label(__('field.nurse'))
                    ->relationship('nurse', 'full_name', fn (Builder $query) => $query->onlyNurses())
                    ->multiple()
                    ->hidden(fn () => auth()->user()->isNurse()),

                SelectFilter::make('county')
                    ->label(__('field.county'))
                    ->options(
                        fn () => Cache::driver('array')
                            ->rememberForever(
                                'counties',
                                fn () => County::pluck('name', 'id')
                            )
                    )
                    ->query(function (Builder $query, array $data) {
                        if (blank($data['value'])) {
                            return $query;
                        }

                        $query->whereRelation('nurse.activityCounty', 'counties.id', $data['value']);
                    })
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
                        $data['type'] = Type::ADMINISTRATIVE;

                        return CommunityActivity::create($data);
                    })
                    ->label(__('community_activity.action.create_administrative'))
                    ->modalHeading(__('community_activity.action.create_administrative'))
                    ->authorize(CommunityActivityResource::canCreate())
                    ->disableCreateAnother(),
            ])
            ->defaultSort('id', 'desc');
    }
}
