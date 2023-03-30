<?php

declare(strict_types=1);

namespace App\Forms\Components;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\Concerns;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class Value extends Component
{
    use Concerns\HasHelperText;
    use Concerns\HasHint;
    use Concerns\HasName;

    protected string $view = 'forms.components.value';

    protected bool $empty = false;

    protected $content = null;

    protected $fallback = null;

    final public function __construct(string $name)
    {
        $this->name($name);
        $this->statePath($name);
    }

    public static function make(string $name): static
    {
        $static = app(static::class, ['name' => $name]);
        $static->configure();

        return $static;
    }

    public function empty(): static
    {
        $this->empty = true;

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

    public function content($content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getContent()
    {
        if ($this->empty) {
            return null;
        }

        $content = $this->evaluate($this->content);

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
