<?php

declare(strict_types=1);

namespace App\Filament\Forms\Components;

use App\Concerns\Forms\HasComponentActions;
use App\Concerns\Forms\HasFooter;
use App\Concerns\Forms\HasHeader;
use Closure;
use Filament\Forms\Components\Card as BaseCard;
use Illuminate\Contracts\Support\Htmlable;

class Card extends BaseCard
{
    use HasComponentActions;
    use HasFooter;
    use HasHeader;

    protected string $view = 'components.forms.card';

    protected string | Htmlable | Closure | null $pointer = null;

    public function pointer(string $pointer = 'left'): static
    {
        $this->pointer = $pointer;

        return $this;
    }

    public function getPointer(): string | Htmlable | null
    {
        return $this->evaluate($this->pointer);
    }
}
