<?php

declare(strict_types=1);

namespace App\Forms\Components;

use App\Models\City;
use App\Models\County;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Illuminate\Support\Facades\Cache;

class Location extends Group
{
    public static function make(array $schema = []): static
    {
        return parent::make(static::getSchema())
            ->columnSpanFull()
            ->columns(2);
    }

    protected static function getSchema(): array
    {
        return [
            Select::make('county_id')
                ->options(County::pluck('name', 'id'))
                ->label(__('user.profile.field.county'))
                ->reactive()
                ->afterStateUpdated(fn (callable $set) => $set('city_id', null)),

            Select::make('city_id')
                ->relationship('city', 'name')
                ->label(__('user.profile.field.city'))
                ->options(
                    function (callable $get) {
                        $countyId = $get('county_id');

                        if (! $countyId) {
                            return null;
                        }

                        return Cache::driver('array')->rememberForever(
                            "cities-for-county-$countyId",
                            fn () => City::query()
                                ->where('county_id', $countyId)
                                ->pluck('name', 'id')
                        );
                    }
                ),
        ];
    }
}
