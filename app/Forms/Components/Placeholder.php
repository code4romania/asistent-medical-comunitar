<?php

declare(strict_types=1);

namespace App\Forms\Components;

use Filament\Forms\Components\Placeholder as BasePlaceholder;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class Placeholder extends BasePlaceholder
{
    protected bool $withoutContent = false;

    protected $fallback = null;

    public function withoutContent(): static
    {
        $this->withoutContent = true;

        return $this;
    }

    public function fallback($fallback): static
    {
        $this->fallback = $fallback;

        return $this;
    }

    public function getFallback()
    {
        return $this->evaluate($this->fallback);
    }

    public function getContent()
    {
        if ($this->withoutContent) {
            return null;
        }

        $content = parent::getContent();

        if (! $content instanceof HtmlString) {
            $content = Str::of($content)
                ->trim()
                ->toHtmlString();
        }

        if ($content->isEmpty()) {
            return $this->getFallback() ?? new HtmlString('<span class="text-gray-500">&mdash;</span>');
        }

        return $content;
    }
}
