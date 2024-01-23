<?php

declare(strict_types=1);

namespace App\Filament\Forms\Components;

use Closure;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\Concerns;
use Illuminate\Support\Collection;

class FileList extends Component
{
    use Concerns\HasHelperText;
    use Concerns\HasHint;
    use Concerns\HasName;

    protected string $view = 'components.forms.file-list';

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

    public function getCollection(): string
    {
        return $this->evaluate($this->collection);
    }

    public function shouldOpenUrlInNewTab(): bool
    {
        return (bool) $this->evaluate($this->shouldOpenUrlInNewTab);
    }

    public function getFiles(): Collection
    {
        return $this->getRecord()
            ->getMedia($this->getCollection());
    }
}
