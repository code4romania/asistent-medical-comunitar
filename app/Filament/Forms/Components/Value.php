<?php

declare(strict_types=1);

namespace App\Filament\Forms\Components;

use App\Contracts\Stringable;
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

    protected string $view = 'components.forms.value';

    protected bool $empty = false;

    protected string | Htmlable | Closure | null $content = null;

    protected string | Htmlable | Closure | null $fallback = null;

    protected string | Htmlable | Closure | null $url = null;

    protected bool | Closure $shouldOpenUrlInNewTab = false;

    protected $withTime = false;

    protected array $boolean = [];

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

    public function boolean(?string $trueLabel = null, ?string $falseLabel = null): static
    {
        $this->boolean = [
            1 => $trueLabel ?? __('forms::components.select.boolean.true'),
            0 => $falseLabel ?? __('forms::components.select.boolean.false'),
        ];

        return $this;
    }

    public function url(string | Closure | null $url, bool | Closure $shouldOpenInNewTab = false): static
    {
        $this->shouldOpenUrlInNewTab = $shouldOpenInNewTab;
        $this->url = $url;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->evaluate($this->url);
    }

    public function openUrlInNewTab(bool | Closure $condition = true): static
    {
        $this->shouldOpenUrlInNewTab = $condition;

        return $this;
    }

    public function shouldOpenUrlInNewTab(): bool
    {
        return (bool) $this->evaluate($this->shouldOpenUrlInNewTab);
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

        $content = $this->evaluate($this->content) ?? data_get($this->getRecord(), $this->getName());

        if (! empty($this->boolean)) {
            $content = $this->boolean[\intval(\boolval($content))];
        }

        $content = match (true) {
            $content instanceof BackedEnum => $this->getEnumLabel($content),
            $content instanceof Carbon => $this->getFormattedDate($content),
            $content instanceof Collection => $this->getFormattedCollection($content),
            default => $content,
        };

        if (! $content instanceof HtmlString) {
            $content = Str::of($content)
                ->trim()
                ->toHtmlString();
        }

        if (! $content->isEmpty()) {
            if (null !== ($url = $this->getUrl())) {
                $content = Str::of($content)
                    ->wrap(
                        sprintf(
                            '<a href="%s"%s class="filament-link inline-flex items-center justify-center gap-0.5 font-medium outline-none hover:underline focus:underline text-primary-600 hover:text-primary-500">',
                            $url,
                            $this->shouldOpenUrlInNewTab() ? ' target="_blank" rel="noopener"' : '',
                        ),
                        '</a>'
                    )
                    ->toHtmlString();
            }

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

    protected function getFormattedCollection(Collection $collection, string $glue = ', '): string
    {
        return $collection
            ->map(fn ($item) => match (true) {
                $item instanceof Htmlable => $item->toHtml(),
                $item instanceof Stringable => $item->toString(),
                default => $item
            })
            ->join($glue);
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
