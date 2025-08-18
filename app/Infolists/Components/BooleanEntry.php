<?php

declare(strict_types=1);

namespace App\Infolists\Components;

use Filament\Infolists\Components\Entry;

class BooleanEntry extends Entry
{
    protected string $view = 'infolists.components.boolean-entry';

    protected ?string $trueLabel = null;

    protected ?string $falseLabel = null;

    public function trueLabel(string $label): static
    {
        $this->trueLabel = $label;

        return $this;
    }

    public function falseLabel(string $label): static
    {
        $this->falseLabel = $label;

        return $this;
    }

    public function getState(): string
    {
        $state = parent::getState();

        return $state
            ? $this->trueLabel ?? __('filament-forms::components.select.boolean.true')
            : $this->falseLabel ?? __('filament-forms::components.select.boolean.false');
    }
}
