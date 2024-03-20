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
use App\Models\County;
use Filament\Resources\Pages\ManageRecords;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;

class ManageCampaigns extends ManageRecords implements WithTabs
{
    use Concerns\HasActions;
    use Concerns\HasEmptyState;
    use Concerns\HasTabs;

    protected static string $resource = CommunityActivityResource::class;

    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()->onlyCampaigns();
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
                    ->limit(30)
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

                TextColumn::make('nurse.activityCounty.name')
                    ->label(__('field.county'))
                    ->size('sm')
                    ->sortable()
                    ->toggleable()
                    ->visible(fn () => auth()->user()->isAdmin()),

                TextColumn::make('location')
                    ->label(__('field.location'))
                    ->size('sm')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('organizer')
                    ->label(__('field.organizer'))
                    ->size('sm')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('participants')
                    ->label(__('field.participants'))
                    ->size('sm')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                DateRangeFilter::make('date_between'),

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
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->form(CommunityActivityResource::getCampaignViewFormSchema())
                    ->modalHeading(fn (CommunityActivity $record) => $record->title)
                    ->iconButton(),

                Tables\Actions\EditAction::make()
                    ->form(CommunityActivityResource::getCampaignEditFormSchema())
                    ->modalHeading(fn (CommunityActivity $record) => $record->title)
                    ->iconButton(),

                Tables\Actions\DeleteAction::make()
                    ->modalHeading(fn (CommunityActivity $record) => $record->title)
                    ->iconButton(),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->form(CommunityActivityResource::getCampaignEditFormSchema())
                    ->using(function (array $data) {
                        $data['type'] = CommunityActivityType::CAMPAIGN;

                        return CommunityActivity::create($data);
                    })
                    ->label(__('community_activity.action.create_campaign'))
                    ->modalHeading(__('community_activity.action.create_campaign'))
                    ->visible(fn () => auth()->user()->can('create', CommunityActivity::class))
                    ->disableCreateAnother(),
            ])
            ->defaultSort('id', 'desc');
    }
}
