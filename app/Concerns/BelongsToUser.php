<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToUser
{
    public function initializeBelongsToUser(): void
    {
        $this->fillable[] = 'user_id';
    }

    public static function bootBelongsToUser(): void
    {
        static::addGlobalScope('forCurrentUser', function (Builder $builder) {
            if (! auth()->check()) {
                return;
            }

            $builder->forUser(auth()->user());
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function restrictScopeToCurrentUser(): bool
    {
        return false;
    }

    public function scopeForUser(Builder $query, User $user): Builder
    {
        if (
            $this->restrictScopeToCurrentUser() ||
            $user->isNurseOrMediator()
        ) {
            return $query->where('user_id', $user->id);
        }

        if ($user->isCoordinator()) {
            return $query->whereRelation('user', 'activity_county_id', $user->county_id);
        }

        return $query;
    }
}
