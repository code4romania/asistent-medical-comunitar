<?php

declare(strict_types=1);

namespace App\Concerns\Enums;

trait HasDescription
{
    protected function descriptionKeyPrefix(): ?string
    {
        return 'vulnerability.description';
    }

    public function description(): string
    {
        $description = collect([$this->descriptionKeyPrefix(), $this->value])
            ->filter()
            ->implode('.');

        return __($description);
    }
}
