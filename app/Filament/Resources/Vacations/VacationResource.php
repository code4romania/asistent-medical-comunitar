<?php

declare(strict_types=1);

namespace App\Filament\Resources\Vacations;

use Filament\Schemas\Schema;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use App\Filament\Resources\Vacations\Pages\ManageVacations;
use App\Filament\Resources\VacationResource\Pages;
use App\Filament\Resources\Vacations\Schemas\VacationForm;
use App\Filament\Resources\Vacations\Schemas\VacationInfolist;
use App\Models\County;
use App\Models\Vacation;
use App\Tables\Columns\TextColumn;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;

class VacationResource extends Resource
{
    protected static ?string $model = Vacation::class;

    protected static ?int $navigationSort = 6;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function shouldRegisterNavigation(): bool
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

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components(VacationForm::getSchema());
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components(VacationInfolist::getSchema());
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
            ->recordActions([
                ViewAction::make()
                    ->iconButton(),

                EditAction::make()
                    ->iconButton(),

                DeleteAction::make()
                    ->iconButton(),
            ])
            ->defaultSort('id', 'desc');
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageVacations::route('/'),
        ];
    }
}
