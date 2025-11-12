<?php

declare(strict_types=1);

namespace App\Filament\Infolists\Components;

use App\Filament\Schemas\Components\Subsection;
use App\Models\City;
use Closure;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Grid;
use Filament\Support\Concerns\CanBeContained;
use Filament\Support\Icons\Heroicon;

class Location extends Component
{
    use CanBeContained;

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

        $this->schema(function () {
            $components = [
                TextEntry::make($this->getCountyField())
                    ->label($this->getCountyLabel())
                    ->when(! $this->hasCity(), fn (TextEntry $component) => $component->columnSpanFull()),

                TextEntry::make($this->getCityField())
                    ->label($this->getCityLabel())
                    ->visible($this->hasCity())
                    ->formatStateUsing(fn (?City $state) => $state?->formatted_name)
                    ->html(),
            ];

            if (! $this->isContained()) {
                return [
                    Grid::make()
                        ->components($components),
                ];
            }

            return [
                Subsection::make()
                    ->icon(Heroicon::OutlinedMapPin)
                    ->columns()
                    ->components($components),
            ];
        });
    }

    public function getCountyField(): string
    {
        return collect([
            $this->getId(),
            'county.name',
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
        return collect([
            $this->getId(),
            'city',
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
