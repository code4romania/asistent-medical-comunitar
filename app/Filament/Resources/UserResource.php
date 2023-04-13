<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\ProfileResource\Pages as ProfilePages;
use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use App\Tables\Columns\BadgeColumn;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
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

                TextColumn::make('areas.county.name')
                    ->label(__('field.county'))
                    ->toggleable(),

                TextColumn::make('areas.city.name')
                    ->label(__('field.area'))
                    ->toggleable(),

                TextColumn::make('beneficiaries_count')
                    ->label(__('field.beneficiaries_count'))
                    ->counts('beneficiaries')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('services_count'),
                //     ->label(__('field.services_count'))
                //     ->counts('services')
                //     ->sortable()
                //     ->toggleable(),

                TextColumn::make('employer')
                    ->label(__('field.employer_name')),

                BadgeColumn::make('status'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->iconButton(),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'active' => Pages\ListActiveUsers::route('/active'),
            'inactive' => Pages\ListInactiveUsers::route('/inactive'),

            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}/view'),

            'general.view' => ProfilePages\ViewGeneral::route('/{record}/general'),
            'general.edit' => ProfilePages\EditGeneral::route('/{record}/general/edit'),

            'studies.view' => ProfilePages\ViewStudies::route('/{record}/studies'),
            'studies.edit' => ProfilePages\EditStudies::route('/{record}/studies/edit'),

            'employers.view' => ProfilePages\ViewEmployers::route('/{record}/employers'),
            'employers.edit' => ProfilePages\EditEmployers::route('/{record}/employers/edit'),

            'area.view' => ProfilePages\ViewArea::route('/{record}/area'),
            'area.edit' => ProfilePages\EditArea::route('/{record}/area/edit'),
        ];
    }
}
