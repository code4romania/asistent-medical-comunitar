<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\VacationType;
use App\Filament\Resources\VacationResource\Pages;
use App\Filament\Tables\Columns\TextColumn;
use App\Models\Vacation;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class VacationResource extends Resource
{
    protected static ?string $model = Vacation::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('type')
                    ->label(__('field.type'))
                    ->options(VacationType::options())
                    ->enum(VacationType::class)
                    ->required(),

                Grid::make()
                    ->schema([
                        DatePicker::make('start_date')
                            ->required(),

                        DatePicker::make('end_date')
                            ->after('start_date')
                            ->required(),
                    ])
                    ->columnSpanFull(),

                Textarea::make('notes')
                    ->label(__('field.notes'))
                    ->autosize(false)
                    ->rows(4)
                    ->columnSpanFull()
                    ->extraInputAttributes([
                        'class' => 'resize-none',
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
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

                TextColumn::make('type')
                    ->label(__('field.type'))
                    ->size('sm')
                    ->limit(30)
                    ->searchable()
                    ->toggleable(),

                TextColumn::make('start_date')
                    ->label(__('field.start_date'))
                    ->size('sm')
                    ->date()
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('end_date')
                    ->label(__('field.end_date'))
                    ->size('sm')
                    ->date()
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ManageVacations::route('/'),
        ];
    }
}
