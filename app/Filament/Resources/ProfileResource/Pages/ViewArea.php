<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProfileResource\Pages;

use App\Filament\Forms\Components\Location;
use App\Filament\Forms\Components\Subsection;
use App\Filament\Forms\Components\Value;
use App\Models\City;
use App\Models\User;
use Filament\Forms\Form;

class ViewArea extends ViewRecord
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
                        ->content(fn (User $record) => $record->activityCounty?->name),

                    Value::make('activity_cities')
                        ->label(__('field.cities'))
                        ->content(
                            fn (User $record) => $record->activityCities
                                ?->map(fn (City $city) => Location::getRenderedOptionLabel($city))
                                ->join(', ')
                        ),
                ]),
        ];
    }

    public function getRelationManagers(): array
    {
        return [];
    }
}
