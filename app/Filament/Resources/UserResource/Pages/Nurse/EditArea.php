<?php

declare(strict_types=1);

namespace App\Filament\Resources\UserResource\Pages\Nurse;

use App\Forms\Components\Location;
use App\Forms\Components\Subsection;
use App\Models\City;
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
                    Select::make('activity_county_id')
                        ->label(__('field.county'))
                        ->placeholder(__('placeholder.county'))
                        ->relationship('activityCounty', 'name')
                        ->searchable()
                        ->live()
                        ->preload()
                        ->required()
                        ->afterStateUpdated(function (\Filament\Forms\Set $set) {
                            $set('activity_cities', null);
                        })
                        ->disabled(fn () => ! auth()->user()->isAdmin()),

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
