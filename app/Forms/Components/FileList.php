<?php

declare(strict_types=1);

namespace App\Forms\Components;

use Closure;
use Filament\Forms\Components\Concerns\HasHelperText;
use Filament\Forms\Components\Concerns\HasHint;
use Filament\Forms\Components\Concerns\HasName;
use Filament\Schemas\Components\Component;

/**
 * @deprecated Use `App\Infolists\Components\FileList` instead.
 */
class FileList extends Component
{
    use HasHelperText;
    use HasHint;
    // use HasName;

    protected string $view = 'forms.components.file-list';

    protected bool | Closure $shouldOpenUrlInNewTab = false;

    protected string | Closure $collection = 'default';

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

    public function collection(string | Closure $collection = 'default'): static
    {
        $this->collection = $collection;

        return $this;
    }

    public function getCollection(): string | null
    {
        return $this->evaluate($this->collection);
    }

    public function shouldOpenUrlInNewTab(): bool
    {
        return (bool) $this->evaluate($this->shouldOpenUrlInNewTab);
    }

    public function getState(): array
    {
        return $this->getRecord()
            ->getMedia($this->getCollection())
            ->all();
    }
}
