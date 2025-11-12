<?php

declare(strict_types=1);

namespace App\Filament\Infolists\Components;

use App\Concerns\HasBooleanLabels;
use Filament\Infolists\Components\Entry;

class BooleanEntry extends Entry
{
    use HasBooleanLabels;

    protected string $view = 'filament.infolists.components.boolean-entry';

    public function getState(): string
    {
        $state = parent::getState();

        return \boolval($state)
            ? $this->getTrueLabel()
            : $this->getFalseLabel();
    }
}
