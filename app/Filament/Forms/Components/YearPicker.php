<?php

declare(strict_types=1);

namespace App\Filament\Forms\Components;

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
        $this->options(range($this->getMaxYear(), $this->getMinYear()));

        parent::setUp();
    }
}
