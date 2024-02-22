<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProfileResource\Pages;

use App\Filament\Forms\Components\Location;
use App\Filament\Forms\Components\Subsection;
use App\Filament\Forms\Components\Value;
use App\Models\City;
use App\Models\User;
use Closure;
use Filament\Forms\Components\Select;
use Filament\Resources\Form;

class EditArea extends EditRecord
{
    protected function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema(static::getSchema());
    }

    public static function getSchema(): array
    {
        return [
            Subsection::make()
                ->icon('heroicon-o-location-marker')
                ->columns()
                ->schema([
                    Value::make('activity_county')
                        ->label(__('field.county'))
                        ->content(fn (?User $record) => $record?->activityCounty?->name),

                    Select::make('activity_cities')
                        ->label(__('field.cities'))
                        ->placeholder(__('placeholder.cities'))
                        ->relationship('activityCities', 'name')
                        ->multiple()
                        ->allowHtml()
                        ->searchable()
                        ->required()
                        ->getSearchResultsUsing(
                            fn (string $search, Closure $get) => City::query()
                                ->where('county_id', $get('activity_county_id'))
                                ->search($search)
                                ->limit(100)
                                ->get()
                                ->mapWithKeys(fn (City $city) => [
                                    $city->getKey() => 'Location::getRenderedOptionLabel($city)',
                                ])
                        )
                        ->getOptionLabelFromRecordUsing(
                            fn (City $record) => Location::getRenderedOptionLabel($record)
                        ),
                ]),
        ];
    }
}
