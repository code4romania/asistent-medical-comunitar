<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProfileResource\Concerns;

trait ResolvesRecord
{
    public function mount($record = null): void
    {
        $this->record = auth()->user();

        $this->fillForm();
    }
}
