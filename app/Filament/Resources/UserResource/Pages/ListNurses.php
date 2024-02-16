<?php

declare(strict_types=1);

namespace App\Filament\Resources\UserResource\Pages;

use App\Enums\User\Status;
use App\Filament\Forms\Components\Location;
use App\Filament\Tables\Columns\BadgeColumn;
use App\Filament\Tables\Columns\TextColumn;
use App\Models\User;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;

class ListNurses extends ListUsers
{
    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()
            ->onlyNurses()
            ->when(auth()->user()->isCoordinator(), function (Builder $query) {
                $query->whereRelation('activityCounty', 'counties.id', auth()->user()->county_id);
            })
            ->with([
                'activityCounty',
                'activityCities',
                'latestEmployer',
            ]);
    }

    protected function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('field.id'))
                    ->prefix('#')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('username')
                    ->label(__('field.username'))
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

                TextColumn::make('activityCounty.name')
                    ->label(__('field.county'))
                    ->toggleable(),

                TextColumn::make('activityCities.name')
                    ->label(__('field.area'))
                    ->getStateUsing(
                        fn (User $record) => new HtmlString(
                            $record->activityCities
                                ->map(fn ($city) => Location::getRenderedOptionLabel($city))
                                ->join(', ')
                        )
                    )
                    ->wrap()
                    ->toggleable(),

                TextColumn::make('beneficiaries_count')
                    ->label(__('field.beneficiaries_count'))
                    ->counts('beneficiaries')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('interventions_count')
                    ->label(__('field.performed_interventions_count'))
                    ->counts('interventions')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('latestEmployer.name')
                    ->label(__('field.employer')),

                BadgeColumn::make('status')
                    ->label(__('field.status'))
                    ->enum(Status::options())
                    ->colors(Status::flipColors()),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label(__('field.status'))
                    ->options(Status::options())
                    ->query(function (Builder $query, array $data) {
                        $status = Status::tryFrom((string) $data['value']);

                        return match ($status) {
                            Status::ACTIVE => $query->onlyActive(),
                            Status::INACTIVE => $query->onlyInactive(),
                            Status::INVITED => $query->onlyInvited(),
                            default => $query,
                        };
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->iconButton(),
            ])
            ->bulkActions([
                //
            ]);
    }
}
