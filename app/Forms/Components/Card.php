<?php

declare(strict_types=1);

namespace App\Forms\Components;

use Closure;
use Filament\Forms\Components\Card as BaseCard;
use Illuminate\Contracts\Support\Htmlable;

class Card extends BaseCard
{
    protected string $view = 'forms.components.card';

    protected string | Htmlable | Closure | null $header = null;

    protected string | Htmlable | Closure | null $footer = null;

    public function header(string | Htmlable | Closure | null $header): static
    {
        $this->header = $header;

        return $this;
    }

    public function getHeader(): string | Htmlable | null
    {
        return $this->evaluate($this->header);
    }

    public function footer(string | Htmlable | Closure | null $footer): static
    {
        $this->footer = $footer;

        return $this;
    }

    public function getFooter(): string | Htmlable | null
    {
        return $this->evaluate($this->footer);
    }
}
