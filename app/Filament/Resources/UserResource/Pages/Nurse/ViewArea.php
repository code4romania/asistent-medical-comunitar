<?php

declare(strict_types=1);

namespace App\Filament\Resources\UserResource\Pages\Nurse;

use App\Filament\Forms\Components\Location;
use App\Filament\Forms\Components\Subsection;
use App\Filament\Forms\Components\Value;
use App\Models\City;
use App\Models\User;
use Filament\Resources\Form;

class ViewArea extends ViewRecord
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

    protected function getRelationManagers(): array
    {
        return [];
    }
}
