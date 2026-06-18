<?php

declare(strict_types=1);

namespace App\Filament\Widgets\Components;

use App\Exceptions\InvalidDataObjectException;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget\Stat as BaseStat;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Number;

class Stat extends BaseStat
{
    public static function make(string | Htmlable $label, $value = null): static
    {
        return app(static::class, ['label' => $label, 'value' => $value]);
    }

    public function trend(object $data, int $precision = 0): static
    {
        if (! property_exists($data, 'current') || ! property_exists($data, 'previous')) {
            throw new InvalidDataObjectException;
        }

        $this->value($data->current);

        if (! $data->previous) {
            return $this;
        }

        $trend = (\floatval($data->current) - \floatval($data->previous)) / $data->previous * 100;

        $this->description(number_format(abs($trend), $precision, ',', '.') . '%');

        $this->descriptionIcon(match (true) {
            $trend > 0 => Heroicon::ArrowTrendingUp,
            $trend < 0 => Heroicon::ArrowTrendingDown,
            default => null,
        });

        $this->color(match (true) {
            $trend > 0 => 'success',
            $trend < 0 => 'danger',
            default => null,
        });

        return $this;
    }

    public function getValue(): mixed
    {
        $value = parent::getValue();

        if (\is_int($value)) {
            return Number::format($value, precision: 0);
        }

        if (\is_float($value)) {
            return Number::format($value, precision: 2);
        }

        return $value;
    }
}
