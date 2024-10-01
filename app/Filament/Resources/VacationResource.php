<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Enums\VacationType;
use App\Filament\Forms\Components\Value;
use App\Filament\Resources\VacationResource\Pages;
use App\Filament\Tables\Columns\TextColumn;
use App\Models\County;
use App\Models\Vacation;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;

class VacationResource extends Resource
{
    protected static ?string $model = Vacation::class;

    protected static ?int $navigationSort = 6;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static function shouldRegisterNavigation(): bool
    {
        return auth()->user()->isAdmin()
            || auth()->user()->isCoordinator();
    }

    public static function getModelLabel(): string
    {
        return __('vacation.label.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('vacation.label.plural');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema(static::getEditFormSchema());
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

                TextColumn::make('nurse.full_name')
                    ->label(__('field.nurse'))
                    ->size('sm')
                    ->toggleable(fn (TextColumn $column) => ! $column->isHidden())
                    ->hidden(fn () => auth()->user()->isNurse()),

                TextColumn::make('nurse.activityCounty.name')
                    ->label(__('field.county'))
                    ->size('sm')
                    ->toggleable(fn (TextColumn $column) => ! $column->isHidden())
                    ->visible(fn () => auth()->user()->isAdmin()),

                TextColumn::make('type')
                    ->label(__('field.type'))
                    ->size('sm')
                    ->limit(30)
                    ->enum(VacationType::options())
                    ->sortable()
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

                SelectFilter::make('nurse')
                    ->label(__('field.nurse'))
                    ->relationship('nurse', 'full_name', fn (Builder $query) => $query->onlyNurses())
                    ->multiple()
                    ->hidden(fn () => auth()->user()->isNurse()),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->form(static::getViewFormSchema())
                    ->iconButton(),

                Tables\Actions\EditAction::make()
                    ->form(static::getEditFormSchema())
                    ->iconButton(),

                Tables\Actions\DeleteAction::make()
                    ->iconButton(),
            ])
            ->bulkActions([
                //
            ])
            ->defaultSort('id', 'desc');
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

    public static function getEditFormSchema(): array
    {
        return [
            Select::make('type')
                ->label(__('field.type'))
                ->options(VacationType::options())
                ->enum(VacationType::class)
                ->required(),

            Grid::make()
                ->schema([
                    DatePicker::make('start_date')
                        ->label(__('field.start_date'))
                        ->required(),

                    DatePicker::make('end_date')
                        ->label(__('field.end_date'))
                        ->afterOrEqual('start_date')
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
        ];
    }

    public static function getViewFormSchema(): array
    {
        return [
            Value::make('type')
                ->label(__('field.type')),

            Grid::make()
                ->schema([
                    Value::make('start_date')
                        ->label(__('field.start_date')),

                    Value::make('end_date')
                        ->label(__('field.end_date')),
                ])
                ->columnSpanFull(),

            Value::make('notes')
                ->label(__('field.notes'))
                ->columnSpanFull(),
        ];
    }
}
