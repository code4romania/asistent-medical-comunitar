<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProfileResource\Pages;

use App\Forms\Components\Location;
use App\Forms\Components\Subsection;
use App\Forms\Components\Value;
use App\Models\City;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;

class EditArea extends EditRecord
{
    public function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema(static::getSchema());
    }

    public static function getSchema(): array
    {
        return [
            Subsection::make()
                ->icon('heroicon-o-map-pin')
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
                            fn (string $search, \Filament\Forms\Get $get) => City::query()
                                ->where('county_id', $get('activity_county_id'))
                                ->search($search)
                                ->limit(100)
                                ->get()
                                ->mapWithKeys(fn (City $city) => [
                                    $city->getKey() => Location::getRenderedOptionLabel($city),
                                ])
                        )
                        ->getOptionLabelFromRecordUsing(
                            fn (City $record) => Location::getRenderedOptionLabel($record)
                        ),
                ]),
        ];
    }
}
