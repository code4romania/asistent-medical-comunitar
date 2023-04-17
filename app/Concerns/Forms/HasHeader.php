<?php

declare(strict_types=1);

namespace App\Concerns\Forms;

use Closure;
use Illuminate\Contracts\Support\Htmlable;

trait HasHeader
{
    protected string | Htmlable | Closure | null $header = null;

    public function header(string | Htmlable | Closure | null $header): static
    {
        $this->header = $header;

        return $this;
    }

    public function getHeader(): string | Htmlable | null
    {
        return $this->evaluate($this->header);
    }
}
