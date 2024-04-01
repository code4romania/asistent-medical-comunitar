<?php

declare(strict_types=1);

namespace App\Concerns\Users;

use App\Enums\User\Status;
use Illuminate\Database\Eloquent\Builder;

trait HasStatus
{
    public function initializeHasStatus()
    {
        $this->casts['deactivated_at'] = 'timestamp';
        $this->fillable[] = 'deactivated_at';
    }

    public function activate(): bool
    {
        return $this->update([
            'deactivated_at' => null,
        ]);
    }

    public function deactivate(): bool
    {
        return $this->update([
            'deactivated_at' => $this->freshTimestamp(),
        ]);
    }

    public function isActive(): bool
    {
        return $this->deactivated_at === null;
    }

    public function isInactive(): bool
    {
        return ! $this->isActive();
    }

    public function getStatusAttribute(): Status
    {
        if ($this->isInactive()) {
            return Status::INACTIVE;
        }

        if (! $this->hasSetPassword()) {
            return Status::INVITED;
        }

        return Status::ACTIVE;
    }

    public function scopeOnlyActive(Builder $query): Builder
    {
        return $query->whereNull('deactivated_at');
    }

    public function scopeOnlyInactive(Builder $query): Builder
    {
        return $query->whereNotNull('deactivated_at');
    }
}
