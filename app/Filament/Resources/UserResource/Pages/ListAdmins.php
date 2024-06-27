<?php

declare(strict_types=1);

namespace App\Filament\Resources\UserResource\Pages;

use App\Enums\User\Status;
use App\Filament\Tables\Columns\BadgeColumn;
use App\Filament\Tables\Columns\TextColumn;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

class ListAdmins extends ListUsers
{
    protected function getTableQuery(): Builder
    {
        return parent::getTableQuery()
            ->onlyAdmins();
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

                TextColumn::make('email')
                    ->label(__('field.email'))
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

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
            ])
            ->defaultSort('id', 'desc');
    }
}
