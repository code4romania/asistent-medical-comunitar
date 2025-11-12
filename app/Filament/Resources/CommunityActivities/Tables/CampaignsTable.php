<?php

declare(strict_types=1);

namespace App\Filament\Resources\CommunityActivities\Tables;

use App\Enums\CommunityActivity\Campaign;
use App\Filament\Resources\CommunityActivities\Actions\CreateCampaignAction;
use App\Filament\Resources\CommunityActivities\Schemas\CampaignForm;
use App\Filament\Resources\CommunityActivities\Schemas\CampaignInfolist;
use App\Models\CommunityActivity;
use App\Models\County;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;

class CampaignsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->whereCampaign())
            ->columns([
                TextColumn::make('id')
                    ->label(__('field.id'))
                    ->prefix('#')
                    ->searchable()
                    ->toggleable()
                    ->sortable(),

                TextColumn::make('nurse.full_name')
                    ->label(__('field.nurse'))
                    ->hidden(fn () => auth()->user()->isNurse())
                    ->toggleable()
                    ->sortable(),

                TextColumn::make('nurse.activityCounty.name')
                    ->label(__('field.county'))
                    ->visible(fn () => auth()->user()->isAdmin())
                    ->toggleable(),

                TextColumn::make('nurse.activitiyCities.name')
                    ->label(__('field.cities'))
                    ->hidden(fn () => auth()->user()->isNurse())
                    ->toggleable(),

                TextColumn::make('subtype')
                    ->label(__('field.type'))
                    ->toggleable(),

                TextColumn::make('name')
                    ->label(__('field.activity'))
                    ->searchable()
                    ->toggleable()
                    ->limit(30),

                TextColumn::make('date')
                    ->label(__('field.date'))
                    ->searchable()
                    ->toggleable()
                    ->sortable()
                    ->date(),

                TextColumn::make('outside_working_hours')
                    ->label(__('field.hour'))
                    ->toggleable()
                    ->sortable(),

                TextColumn::make('location')
                    ->label(__('field.location'))
                    ->searchable()
                    ->toggleable()
                    ->sortable(),

                TextColumn::make('organizer')
                    ->label(__('field.organizer'))
                    ->searchable()
                    ->toggleable()
                    ->sortable(),

                TextColumn::make('participants')
                    ->label(__('field.participants'))
                    ->toggleable()
                    ->sortable(),

                TextColumn::make('roma_participants')
                    ->label(__('field.roma_participants'))
                    ->toggleable()
                    ->sortable(),
            ])
            ->filters([
                DateRangeFilter::make('date')
                    ->label(__('activity.column.created_at')),

                SelectFilter::make('subtype')
                    ->label(__('field.type'))
                    ->options(Campaign::class),

                SelectFilter::make('nurse')
                    ->label(__('field.nurse'))
                    ->relationship('nurse', 'full_name', fn (Builder $query) => $query->onlyNurses())
                    ->multiple()
                    ->hidden(fn () => auth()->user()->isNurse()),

                SelectFilter::make('county')
                    ->label(__('field.county'))
                    ->options(County::cachedList())
                    ->query(function (Builder $query, array $data) {
                        if (blank($data['value'])) {
                            return $query;
                        }

                        $query->whereRelation('nurse.activityCounty', 'counties.id', $data['value']);
                    })
                    ->visible(fn () => auth()->user()->isAdmin()),

            ])
            ->recordActions([
                ViewAction::make()
                    ->schema(fn (Schema $schema) => CampaignInfolist::configure($schema))
                    ->modalHeading(fn (CommunityActivity $record) => $record->title)
                    ->iconButton(),

                EditAction::make()
                    ->schema(fn (Schema $schema) => CampaignForm::configure($schema))
                    ->modalHeading(fn (CommunityActivity $record) => $record->title)
                    ->iconButton(),

                DeleteAction::make()
                    ->modalHeading(fn (CommunityActivity $record) => $record->title)
                    ->iconButton(),
            ])
            ->headerActions([
                CreateCampaignAction::make(),
            ])
            ->defaultSort('id', 'desc');
    }
}
