<?php

declare(strict_types=1);

namespace App\Forms\Components;

use App\Models\City;
use App\Models\County;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Model;

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
                ->searchable()
                ->reactive()
                ->afterStateUpdated(fn (callable $set) => $set('city_id', null)),

            Select::make('city_id')
                ->label(__('user.profile.field.city'))
                ->allowHtml()
                ->searchable()
                ->requiredWith('county_id')
                ->getSearchResultsUsing(function (string $search, callable $get) {
                    $countyId = (int) $get('county_id');

                    if (! $countyId) {
                        return null;
                    }

                    return City::query()
                        ->where('county_id', $countyId)
                        ->search($search)
                        ->limit(100)
                        ->get()
                        ->mapWithKeys(fn (City $city) => [
                            $city->getKey() => static::getRenderedOptionLabel($city),
                        ]);
                })
                ->getOptionLabelUsing(
                    fn ($value) => static::getRenderedOptionLabel(City::find($value))
                ),

        ];
    }

    public static function getRenderedOptionLabel(Model $model): string
    {
        return view('forms.components.select-city-item', [
            'name'        => $model?->name,
            'parent_name' => $model?->parent_name,
        ])->render();
    }
}
