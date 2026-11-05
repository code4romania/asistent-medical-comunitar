<?php

declare(strict_types=1);

namespace App\Filament\Forms\Components;

use App\Contracts\Enums\CanBeFiltered;
use Closure;
use Filament\Actions\Action;
use Filament\Forms\Components\Select as BaseSelect;
use Filament\Support\Enums\Size;

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
            if (! $component->isMultiple() || ! $component->canSelectAll()) {
                return null;
            }

            return Action::make('selectAll')
                ->label(__('app.action.select_all'))
                ->size(Size::ExtraSmall)
                ->link()
                ->action(fn (): Select => $component->state(
                    array_keys($component->getOptions())
                ));
        });
    }

    public function filteredEnum(string $enum): self
    {
        $this->enum($enum);

        $this->options(
            fn (self $component): array => collect($enum::cases())
                ->filter(fn (CanBeFiltered $case): bool => $case->isVisible())
                ->reduce(function (array $carry, CanBeFiltered $case): array {
                    $carry[$case->value ?? $case->name] = $case->getLabel() ?? $case->name;

                    return $carry;
                }, [])
        );

        return $this;
    }
}
