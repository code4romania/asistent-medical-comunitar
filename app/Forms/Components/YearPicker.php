<?php

declare(strict_types=1);

namespace App\Forms\Components;

use Closure;
use Filament\Forms\Components\Select;

class YearPicker extends Select
{
    protected int | Closure $optionsLimit = 100;

    protected int | Closure | null $minYear = null;

    protected int | Closure | null $maxYear = null;

    public function minYear(int | Closure | null $minYear): static
    {
        $this->minYear = $minYear;

        return $this;
    }

    public function maxYear(int | Closure | null $maxYear): static
    {
        $this->maxYear = $maxYear;

        return $this;
    }

    public function getMinYear(): int
    {
        return $this->evaluate($this->minYear) ?? today()
            ->subYearsWithNoOverflow($this->getOptionsLimit())
            ->year;
    }

    public function getMaxYear(): int
    {
        return $this->evaluate($this->maxYear) ?? today()->year;
    }

    protected function setUp(): void
    {
        // Options must be key => value pairs, not just value.
        $range = range($this->getMaxYear(), $this->getMinYear());

        $this->options(array_combine($range, $range));

        parent::setUp();
    }
}
