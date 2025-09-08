<?php

declare(strict_types=1);

namespace App\Filament\Widgets\StatsWidget\Components;

use Filament\Widgets\StatsOverviewWidget\Stat;
use Exception;
use Illuminate\Contracts\Support\Htmlable;

class Card extends Stat
{
    public static function make(string | Htmlable $label, $value = null): static
    {
        return app(static::class, ['label' => $label, 'value' => $value]);
    }

    public function trend(object $data, int $precision = 0): static
    {
        if (! property_exists($data, 'current') || ! property_exists($data, 'previous')) {
            throw new Exception('The data object must have a "current" and "previous" property.');
        }

        $this->value($data->current);

        if (! $data->previous) {
            return $this;
        }

        $trend = (\floatval($data->current) - \floatval($data->previous)) / $data->previous * 100;

        $this->description(number_format(abs($trend), $precision, ',', '.') . '%');

        $this->descriptionIcon(match (true) {
            $trend > 0 => 'heroicon-m-arrow-trending-up',
            $trend < 0 => 'heroicon-m-arrow-trending-down',
            default => null,
        });

        $this->color(match (true) {
            $trend > 0 => 'success',
            $trend < 0 => 'danger',
            default => null,
        });

        return $this;
    }
}
