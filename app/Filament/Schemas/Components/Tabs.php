<?php

declare(strict_types=1);

namespace App\Filament\Schemas\Components;

use Closure;
use Filament\Schemas\Components\Component;

class Tabs extends Component
{
    protected string $view = 'filament.schemas.components.tabs';

    protected array | Closure $tabs = [];

    public static function make(): static
    {
        $static = app(static::class);
        $static->configure();

        return $static;
    }

    public function tabs(array | Closure $tabs): static
    {
        $this->tabs = $tabs;

        return $this;
    }

    public function getTabs(): array
    {
        return $this->evaluate($this->tabs) ?? [];
    }
}
