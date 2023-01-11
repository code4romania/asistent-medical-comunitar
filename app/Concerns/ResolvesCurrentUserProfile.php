<?php

declare(strict_types=1);

namespace App\Concerns;

use Illuminate\Database\Eloquent\Model;

trait ResolvesCurrentUserProfile
{
    public function mount($record = null): void
    {
        parent::mount($record);
    }

    protected function resolveRecord($key): Model
    {
        return auth()->user();
    }
}
