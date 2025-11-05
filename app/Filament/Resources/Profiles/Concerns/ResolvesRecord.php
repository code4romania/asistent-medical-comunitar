<?php

declare(strict_types=1);

namespace App\Filament\Resources\Profiles\Concerns;

trait ResolvesRecord
{
    public function mount($record = null): void
    {
        $this->record = auth()->user();

        if (method_exists($this, 'authorizeAccess')) {
            $this->authorizeAccess();
        }

        if (! method_exists($this, 'hasInfolist') || ! $this->hasInfolist()) {
            $this->fillForm();
        } else {
            $this->callHook('beforeFill');
        }
    }
}
