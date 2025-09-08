<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\Pages\Nurse;

use App\Forms\Components\Location;
use App\Forms\Components\Subsection;
use App\Forms\Components\Value;
use App\Models\City;
use App\Models\User;
use Filament\Schemas\Schema;

class ViewArea extends ViewRecord
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components(static::getSchema());
    }

    public static function getFormSchema(): array
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
