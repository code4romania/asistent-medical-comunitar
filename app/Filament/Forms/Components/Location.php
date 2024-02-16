<?php

declare(strict_types=1);

namespace App\Filament\Forms\Components;

use App\Models\City;
use App\Models\County;
use Filament\Forms\Components\Concerns\CanBeValidated;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Location extends Grid
{
    use CanBeValidated;

    protected bool $withCity = true;

    public function withoutCity(): self
    {
        $this->withCity = false;

        return $this;
    }

    public function getChildComponents(): array
    {
        return match ($this->getContainer()->getContext()) {
            'view' => $this->getViewComponents(),
            default => $this->getEditComponents(),
        };
    }

    protected function getViewComponents(): array
    {
        $county = Value::make('county')
            ->label(__('field.county'))
            ->content(fn ($record) => $record->county?->name);

        $components = [
            ! $this->withCity
                ? $county->columnSpanFull()
                : $county,
        ];

        if ($this->withCity) {
            $components[] = Value::make('city')
                ->label(__('field.city'))
                ->content(fn ($record) => static::getRenderedOptionLabel($record->city));
        }

        return $components;
    }

    protected function getEditComponents(): array
    {
        $county = Select::make('county_id')
            ->label(__('field.county'))
            ->placeholder(__('placeholder.county'))
            ->options(function () {
                return Cache::driver('array')
                    ->rememberForever(
                        'counties',
                        fn () => County::pluck('name', 'id')
                    );
            })
            ->searchable()
            ->reactive()
            ->required($this->isRequired())
            ->disabled($this->isDisabled())
            ->afterStateUpdated(function (callable $set) {
                if (! $this->withCity) {
                    return;
                }

                $set('city_id', null);
            });

        $components = [
            ! $this->withCity
                ? $county->columnSpanFull()
                : $county,
        ];

        if ($this->withCity) {
            $components[] = Select::make('city_id')
                ->label(__('field.city'))
                ->placeholder(__('placeholder.city'))
                ->allowHtml()
                ->searchable()
                ->required($this->isRequired())
                ->disabled($this->isDisabled())
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
                );
        }

        return $components;
    }

    public static function getRenderedOptionLabel(?Model $model): ?string
    {
        if (\is_null($model)) {
            return null;
        }

        return view('components.forms.location.city', [
            'name' => $model->name,
            'suffix' => $model->parent_name,
        ])->render();
    }
}
