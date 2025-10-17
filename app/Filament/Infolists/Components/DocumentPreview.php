<?php

declare(strict_types=1);

namespace App\Filament\Infolists\Components;

use App\Models\Media;
use Closure;
use Filament\Infolists\Components\Entry;

class DocumentPreview extends Entry
{
    protected string $view = 'filament.infolists.components.document-preview';

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

    public static function getDefaultName(): ?string
    {
        return 'preview';
    }

    public function getState(): ?Media
    {
        return $this->getRecord()
            ->getFirstMedia($this->getCollection());
    }
}
