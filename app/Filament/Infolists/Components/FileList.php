<?php

declare(strict_types=1);

namespace App\Filament\Infolists\Components;

use Closure;
use Filament\Infolists\Components\Entry;

class FileList extends Entry
{
    protected string $view = 'filament.infolists.components.file-list';

    protected string | Closure $collection = 'default';

    public function collection(string | Closure $collection = 'default'): static
    {
        $this->collection = $collection;

        return $this;
    }

    public function getCollection(): string
    {
        return $this->evaluate($this->collection);
    }

    public function getState(): array
    {
        return $this->getRecord()
            ->getMedia($this->getCollection())
            ->all();
    }
}
