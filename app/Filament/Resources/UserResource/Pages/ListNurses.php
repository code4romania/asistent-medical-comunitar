<?php

declare(strict_types=1);

namespace App\Filament\Resources\UserResource\Pages;

use App\Enums\User\Status;
use App\Filament\Tables\Columns\BadgeColumn;
use App\Filament\Tables\Columns\TextColumn;
use App\Models\User;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

class ListNurses extends ListUsers
{
    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()
            ->onlyNurses()
            ->when(auth()->user()->isCoordinator(), function (Builder $query) {
                $query->whereRelation('activityCounties', 'counties.id', auth()->user()->county_id);
            })
            ->with([
                'areas.city',
                'areas.county',
                'latestEmployer',
            ]);
    }

    protected function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('field.nurse_id'))
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

                TextColumn::make('activityCounties')
                    ->label(__('field.county'))
                    ->getStateUsing(
                        fn (User $record) => $record->activityCounties
                            ->pluck('name')
                            ->join(', ')
                    )
                    ->wrap()
                    ->toggleable(),

                TextColumn::make('areas.city')
                    ->label(__('field.area'))
                    ->getStateUsing(
                        fn (User $record) => $record->areas
                            ->pluck('city.name')
                            ->join(', ')
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
                // ->getStateUsing(
                //     fn (User $record) => $record->employers
                //         ->pluck('name')
                //         ->join(', ')
                // ),

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
