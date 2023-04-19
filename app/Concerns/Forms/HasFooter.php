<?php

declare(strict_types=1);

namespace App\Concerns\Forms;

use Closure;
use Illuminate\Contracts\Support\Htmlable;

trait HasFooter
{
    protected string | Htmlable | Closure | null $footer = null;

    public function footer(string | Htmlable | Closure | null $footer): static
    {
        $this->footer = $footer;

        return $this;
    }

    public function getFooter(): string | Htmlable | null
    {
        return $this->evaluate($this->footer);
    }
}
