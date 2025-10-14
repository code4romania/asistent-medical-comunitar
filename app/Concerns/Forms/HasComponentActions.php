<?php

declare(strict_types=1);

namespace App\Concerns\Forms;

use Closure;
use Filament\Actions\ActionGroup;
use Illuminate\Support\Arr;

trait HasComponentActions
{
    protected array | ActionGroup | Closure $headerActions = [];

    protected array | ActionGroup | Closure $footerActions = [];

    public function headerActions(array | ActionGroup | Closure $headerActions): static
    {
        $this->headerActions = $headerActions;

        return $this;
    }

    public function getHeaderActions(): array
    {
        return Arr::wrap($this->evaluate($this->headerActions));
    }

    public function footerActions(array | ActionGroup | Closure $footerActions): static
    {
        $this->footerActions = $footerActions;

        return $this;
    }

    public function getFooterActions(): array
    {
        return Arr::wrap($this->evaluate($this->footerActions));
    }
}
