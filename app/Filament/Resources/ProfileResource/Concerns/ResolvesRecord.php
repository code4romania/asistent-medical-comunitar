<?php

declare(strict_types=1);

namespace App\Filament\Resources\ProfileResource\Concerns;

use App\Models\User;

trait ResolvesRecord
{
    public function mount($record = null): void
    {
        parent::mount($record);
    }

    protected function resolveRecord($key): User
    {
        return auth()->user();
    }
}
