<?php

declare(strict_types=1);

namespace App\Forms\Components;

use Filament\Schemas\Components\Component;
use App\Models\Media;
use Closure;

class DocumentPreview extends Component
{
    protected string $view = 'forms.components.document-preview';

    protected string | Closure $collection = 'default';

    public static function make(): static
    {
        $static = app(static::class);
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

    public function getFile(): ?Media
    {
        return $this->getRecord()
            ->getFirstMedia($this->getCollection());
    }
}
