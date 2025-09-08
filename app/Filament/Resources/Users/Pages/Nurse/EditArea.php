<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\Pages\Nurse;

use App\Forms\Components\Location;
use App\Forms\Components\Subsection;
use App\Models\City;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class EditArea extends EditRecord
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components(static::getFormSchema());
    }

    public static function getFormSchema(): array
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
                        ->afterStateUpdated(function (Set $set) {
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
                            fn (string $search, Get $get) => City::query()
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
