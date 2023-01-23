<?php

declare(strict_types=1);

namespace App\Forms\Components;

use App\Models\City;
use App\Models\County;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;

class Location extends Grid
{
    public function getChildComponents(): array
    {
        return match ($this->getContainer()->getContext()) {
            'view' => $this->getViewComponents(),
            'edit' => $this->getEditComponents(),
        };
    }

    protected function getViewComponents(): array
    {
        return [
            Placeholder::make('county')
                ->label(__('user.profile.field.county'))
                ->content(fn ($record) => $record->county?->name),
            Placeholder::make('city')
                ->label(__('user.profile.field.city'))
                ->content(fn ($record) => static::getRenderedOptionLabel($record->city)),
        ];
    }

    protected function getEditComponents(): array
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
                            $city->getKey() => static::getRenderedOptionLabel($city)->toHtml(),
                        ]);
                })
                ->getOptionLabelUsing(
                    fn ($value) => static::getRenderedOptionLabel(City::find($value))->toHtml()
                ),

        ];
    }

    private static function getRenderedOptionLabel(?Model $model): ?HtmlString
    {
        if (\is_null($model)) {
            return null;
        }

        $html = view('forms.components.select-city-item', [
            'name' => $model->name,
            'suffix' => $model->parent_name,
        ])->render();

        return new HtmlString($html);
    }
}
