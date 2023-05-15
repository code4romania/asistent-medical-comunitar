<?php

declare(strict_types=1);

namespace App\Filament\Resources\InterventionResource\RelationManagers;

use App\Filament\Resources\InterventionResource;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;

class InterventionsRelationManager extends RelationManager
{
    protected static string $relationship = 'interventions';

    protected static ?string $recordTitleAttribute = 'name';

    public static function getTitle(): string
    {
        return __('case.services');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema(
                InterventionResource::getIndividualServiceFormSchema()
            );
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label(__('field.id'))
                    ->prefix('#'),

                TextColumn::make('service.name')
                    ->label(__('field.name')),

                TextColumn::make('status')
                    ->label(__('field.status')),

                TextColumn::make('integrated')
                    ->label(__('field.integrated')),

                TextColumn::make('date')
                    ->label(__('field.date')),

                TextColumn::make('notes')
                    ->label(__('field.notes'))
                    ->wrap()
                    ->limit(40),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->icon('heroicon-o-plus-circle')
                    ->label(__('intervention.action.add_service'))
                    ->modalHeading(__('intervention.action.add_service')),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                // Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
