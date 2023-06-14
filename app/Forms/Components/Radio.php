<?php

declare(strict_types=1);

namespace App\Forms\Components;

use Closure;
use Filament\Forms\Components\Radio as BaseRadio;

class Radio extends BaseRadio
{
    protected string $view = 'components.forms.radio';

    protected bool | Closure $hasInlineOptions = false;

    public function inlineOptions(bool | Closure $condition = true): static
    {
        $this->hasInlineOptions = $condition;

        return $this;
    }

    public function hasInlineOptions(): bool
    {
        return (bool) $this->evaluate($this->hasInlineOptions);
    }

    public function boolean(?string $trueLabel = null, ?string $falseLabel = null): static
    {
        $this->options([
            1 => $trueLabel ?? __('forms::components.select.boolean.true'),
            0 => $falseLabel ?? __('forms::components.select.boolean.false'),
        ]);

        return $this;
    }
}
