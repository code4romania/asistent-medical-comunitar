<?php

declare(strict_types=1);

namespace App\Concerns\Forms;

use Closure;
use Illuminate\Contracts\Support\Htmlable;

trait HasTitle
{
    protected string | Htmlable | Closure | null $title = null;

    public function title(string | Htmlable | Closure | null $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle(): string | Htmlable | null
    {
        return $this->evaluate($this->title);
    }
}
