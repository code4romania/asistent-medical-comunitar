<?php

declare(strict_types=1);

namespace App\Filament\Forms\Components;

use App\Models\City;
use App\Models\County;
use Closure;
use Filament\Forms\Components\Concerns\CanBeValidated;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Concerns\EntanglesStateWithSingularRelationship;
use Filament\Schemas\Components\Contracts\CanEntangleWithSingularRelationships;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;

class Location extends Component implements CanEntangleWithSingularRelationships
{
    use EntanglesStateWithSingularRelationship;
    use CanBeValidated;

    protected string $view = 'filament-schemas::components.grid';

    protected string | Closure | null $countyField = null;

    protected string | null $countyLabel = null;

    protected bool $hasCity = true;

    protected string | Closure | null $cityField = null;

    protected string | null $cityLabel = null;

    final public function __construct(string | null $id)
    {
        $this->id($id);
    }

    public static function make(string | null $id = null): static
    {
        $static = app(static::class, ['id' => $id]);
        $static->configure();

        return $static;
    }

    protected function setUp(): void
    {
        $this->columnSpanFull();

        $this->schema(fn () => [
            Grid::make()
                ->components([
                    Select::make($this->getCountyField())
                        ->label($this->getCountyLabel())
                        ->placeholder(__('placeholder.county'))
                        ->options(County::cachedList())
                        ->searchable()
                        ->preload()
                        ->live()
                        ->required($this->isRequired())
                        ->afterStateUpdated(function (Set $set) {
                            if (! $this->hasCity()) {
                                return;
                            }

                            $set($this->getCityField(), null);
                        })
                        ->when(! $this->hasCity(), fn (Select $component) => $component->columnSpanFull()),

                    Select::make($this->getCityField())
                        ->label($this->getCityLabel())
                        ->placeholder(__('placeholder.city'))
                        ->allowHtml()
                        ->searchable()
                        ->required($this->isRequired())
                        ->getSearchResultsUsing(function (string $search, Get $get) {
                            $countyId = (int) $get($this->getCountyField());

                            if (! $countyId) {
                                return [];
                            }

                            return City::query()
                                ->where('county_id', $countyId)
                                ->search($search)
                                ->limit(50)
                                ->get()
                                ->mapWithKeys(fn (City $city) => [
                                    $city->getKey() => $city->formatted_name,
                                ]);
                        })
                        ->visible(fn () => $this->hasCity())
                        ->getOptionLabelUsing(fn (int $value) => City::findOrFail($value)->formatted_name),
                ]),
        ]);
    }

    public function getCountyField(): string
    {
        return $this->getRelationshipName() ? 'county_id' : collect([
            $this->getId(),
            'county_id',
        ])
            ->filter()
            ->join('_');
    }

    public function getCountyLabel(): string
    {
        return $this->countyLabel ?? __('field.' . collect([
            $this->getId(),
            'county',
        ])
            ->filter()
            ->join('_'));
    }

    public function city(bool | Closure $condition = true): static
    {
        $this->hasCity = $condition;

        return $this;
    }

    public function hasCity(): bool
    {
        return (bool) $this->evaluate($this->hasCity);
    }

    public function getCityField(): string
    {
        return $this->getRelationshipName() ? 'city_id' : collect([
            $this->getId(),
            'city_id',
        ])
            ->filter()
            ->join('_');
    }

    public function getCityLabel(): string
    {
        return $this->cityLabel ?? __('field.' . collect([
            $this->getId(),
            'city',
        ])
            ->filter()
            ->join('_'));
    }
}
