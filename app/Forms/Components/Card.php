<?php

declare(strict_types=1);

namespace App\Forms\Components;

use Closure;
use Filament\Forms\Components\Card as BaseCard;
use Illuminate\Contracts\Support\Htmlable;

class Card extends BaseCard
{
    protected string $view = 'forms.components.card';

    protected string | Htmlable | Closure | null $heading = null;

    public function heading(string | Htmlable | Closure | null $heading): static
    {
        $this->heading = $heading;

        return $this;
    }

    public function getHeading(): string | Htmlable | null
    {
        return $this->evaluate($this->heading);
    }
}
