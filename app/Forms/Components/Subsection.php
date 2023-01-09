<?php

declare(strict_types=1);

namespace App\Forms\Components;

use Filament\Forms\Components\Component;
use Illuminate\Contracts\Support\Htmlable;

class Subsection extends Component
{
    protected string $view = 'forms.components.subsection';

    protected ?string $icon = null;

    public static function make(): static
    {
        $static = app(static::class);
        $static->configure();

        return $static;
    }

    public function icon(?string $icon = null): static
    {
        $this->icon = $icon;

        return $this;
    }

    public function getIcon(): string | Htmlable | null
    {
        return $this->evaluate($this->icon);
    }
}
