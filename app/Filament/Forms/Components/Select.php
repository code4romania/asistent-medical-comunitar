<?php

declare(strict_types=1);

namespace App\Filament\Forms\Components;

use Closure;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Select as BaseSelect;

class Select extends BaseSelect
{
    protected bool | Closure $canSelectAll = false;

    public function selectAll(bool | Closure $condition = true): static
    {
        $this->canSelectAll = $condition;

        return $this;
    }

    public function canSelectAll(): bool
    {
        return $this->evaluate($this->canSelectAll);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->hintAction(function (self $component) {
            if (! $component->isMultiple()) {
                return null;
            }

            if (! $component->canSelectAll()) {
                return null;
            }

            return Action::make('select-all')
                ->view('components.actions.link-action')
                ->label(__('app.action.select_all'))
                ->action(fn () => $component->state(
                    array_keys($component->getOptions())
                ));
        });
    }
}
