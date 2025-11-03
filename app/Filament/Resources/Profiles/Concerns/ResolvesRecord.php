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

        $this->callHook('beforeFill');
    }
}
