<?php

declare(strict_types=1);

namespace App\Concerns\Forms;

use Closure;
use Filament\Support\Actions\ActionGroup;
use Illuminate\Support\Arr;

trait HasComponentActions
{
    protected array | ActionGroup | Closure $componentActions = [];

    public function componentActions(array | ActionGroup | Closure $componentActions): static
    {
        $this->componentActions = $componentActions;

        return $this;
    }

    public function getComponentActions(): array
    {
        return Arr::wrap($this->evaluate($this->componentActions));
    }
}
