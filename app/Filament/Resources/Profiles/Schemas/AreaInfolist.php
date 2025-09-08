<?php

declare(strict_types=1);

namespace App\Filament\Resources\Profiles\Schemas;

use App\Infolists\Components\Location;
use App\Infolists\Components\Subsection;
use App\Models\City;
use App\Models\User;
use Filament\Infolists\Components\TextEntry;

class AreaInfolist
{
    public static function getSchema(): array
    {
        return [
            Subsection::make()
                ->icon('heroicon-o-map-pin')
                ->columns()
                ->schema([
                    TextEntry::make('activityCounty.name')
                        ->label(__('field.county')),

                    TextEntry::make('activityCities')
                        ->label(__('field.cities'))
                        ->html()
                        ->formatStateUsing(
                            fn (User $record) => $record->activityCities
                                ?->map(fn (City $city) => Location::getRenderedOptionLabel($city)->render())

                                ->join(', ')
                        ),
                ]),
        ];
    }
}
