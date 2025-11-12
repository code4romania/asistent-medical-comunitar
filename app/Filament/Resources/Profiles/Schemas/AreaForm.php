<?php

declare(strict_types=1);

namespace App\Filament\Resources\Profiles\Schemas;

use App\Filament\Schemas\Components\Subsection;
use App\Models\City;
use Filament\Forms\Components\Select;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class AreaForm
{
    public static function configure(Schema $schema, bool $canEditCounty = false): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Subsection::make()
                    ->icon(Heroicon::OutlinedMapPin)
                    ->columns()
                    ->schema([
                        TextEntry::make('activityCounty.name')
                            ->label(__('field.county'))
                            ->hidden($canEditCounty),

                        Select::make('activity_county_id')
                            ->label(__('field.county'))
                            ->placeholder(__('placeholder.county'))
                            ->relationship('activityCounty', 'name')
                            ->searchable()
                            ->reactive()
                            ->preload()
                            ->required()
                            ->afterStateUpdated(function (Set $set) {
                                $set('activity_cities', null);
                            })
                            ->visible($canEditCounty),

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
                                        $city->getKey() => $city->formatted_name,
                                    ])
                            )
                            ->getOptionLabelFromRecordUsing(fn (City $record) => $record->formatted_name),
                    ]),
            ]);
    }
}
