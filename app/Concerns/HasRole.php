<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

trait HasRole
{
    public function initializeHasRole()
    {
        $this->casts['role'] = UserRole::class;

        $this->fillable[] = 'role';
    }

    public function hasRole(string $role): bool
    {
        return $this->role === UserRole::tryFrom($role);
    }

    public function isAdmin(): bool
    {
        return $this->role === UserRole::ADMIN;
    }

    public function isCoordinator(): bool
    {
        return $this->role === UserRole::COORDINATOR;
    }

    public function isMediator(): bool
    {
        return $this->role === UserRole::MEDIATOR;
    }

    public function isNurse(): bool
    {
        return $this->role === UserRole::NURSE;
    }

    public function scopeRole(Builder $query, array|string|Collection|UserRole $roles): Builder
    {
        return $query->whereIn('role', collect($roles));
    }

    public function scopeOnlyNurses(Builder $query): Builder
    {
        return $query->role(UserRole::NURSE);
    }
}
