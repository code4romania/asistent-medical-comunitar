<?php

declare(strict_types=1);

namespace App\Forms\Components;

use Closure;
use Filament\Forms\Components\Radio as BaseRadio;

class Radio extends BaseRadio
{
    protected string $view = 'forms.components.radio';

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
}
