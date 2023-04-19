<?php

declare(strict_types=1);

namespace App\Forms\Components;

use BackedEnum;
use Carbon\Carbon;
use Closure;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Concerns;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class Value extends Component
{
    use Concerns\HasHelperText;
    use Concerns\HasHint;
    use Concerns\HasName;

    protected string $view = 'forms.components.value';

    protected bool $empty = false;

    protected string | Htmlable | Closure | null $content = null;

    protected string | Htmlable | Closure | null $fallback = null;

    protected $withTime = false;

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

    public function fallback(string | Htmlable | Closure | null $fallback): static
    {
        $this->fallback = $fallback;

        return $this;
    }

    public function getFallback(): string | Htmlable | null
    {
        return $this->evaluate($this->fallback);
    }

    public function content(string | Htmlable | Closure | null $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getContent(): string | Htmlable | null
    {
        if ($this->empty) {
            return null;
        }

        $content = $this->evaluate($this->content) ?? $this->getRecord()?->{$this->getName()} ?? null;

        $content = match (true) {
            $content instanceof BackedEnum => $this->getEnumLabel($content),
            $content instanceof Carbon => $this->getFormattedDate($content),
            $content instanceof Collection => $content->join(', '),
            default => $content,
        };

        if (! $content instanceof HtmlString) {
            $content = Str::of($content)
                ->trim()
                ->toHtmlString();
        }

        if (! $content->isEmpty()) {
            return $content;
        }

        if (null !== $fallback = $this->getFallback()) {
            return new HtmlString('<div class="italic">' . $fallback . '</div>');
        }

        return new HtmlString('<span class="text-gray-500">&mdash;</span>');
    }

    public function withTime(bool $condition = true): static
    {
        $this->withTime = $condition;

        return $this;
    }

    protected function getFormattedDate(Carbon $date): string
    {
        return $this->withTime
            ? $date->toFormattedDateTime()
            : $date->toFormattedDate();
    }

    protected function getEnumLabel(BackedEnum $content): ?string
    {
        if (! \in_array(\App\Concerns\Enums\Arrayable::class, class_uses_recursive($content))) {
            return null;
        }

        return $content?->label();
    }
}
