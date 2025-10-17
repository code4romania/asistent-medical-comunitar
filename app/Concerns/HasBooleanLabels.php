<?php

declare(strict_types=1);

namespace App\Concerns;

use Closure;

trait HasBooleanLabels
{
    protected string | Closure | null $trueLabel = null;

    protected string | Closure | null $falseLabel = null;

    public function trueLabel(string | Closure | null $label): static
    {
        $this->trueLabel = $label;

        return $this;
    }

    public function falseLabel(string | Closure | null $label): static
    {
        $this->falseLabel = $label;

        return $this;
    }

    public function getTrueLabel(): string
    {
        return $this->evaluate($this->trueLabel) ?? __('filament-forms::components.select.boolean.true');
    }

    public function getFalseLabel(): string
    {
        return $this->evaluate($this->falseLabel) ?? __('filament-forms::components.select.boolean.false');
    }
}
