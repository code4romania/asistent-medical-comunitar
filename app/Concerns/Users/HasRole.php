<?php

declare(strict_types=1);

namespace App\Concerns\Users;

use App\Enums\User\Role;
use Illuminate\Database\Eloquent\Builder;

trait HasRole
{
    public function initializeHasRole()
    {
        $this->casts['role'] = Role::class;

        $this->fillable[] = 'role';
    }

    public function isAdmin(): bool
    {
        return $this->role->is(Role::ADMIN);
    }

    public function isCoordinator(): bool
    {
        return $this->role->is(Role::COORDINATOR);
    }

    public function isNurse(): bool
    {
        return $this->role->is(Role::NURSE);
    }

    public function scopeOnlyAdmins(Builder $query): Builder
    {
        return $query->where('role', Role::ADMIN);
    }

    public function scopeOnlyCoordinators(Builder $query): Builder
    {
        return $query->where('role', Role::COORDINATOR);
    }

    public function scopeOnlyNurses(Builder $query): Builder
    {
        return $query->where('role', Role::NURSE);
    }
}
