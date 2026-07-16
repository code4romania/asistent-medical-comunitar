<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

interface UserScopable
{
    public function scopeForUser(Builder $query, User $user): Builder;
}
