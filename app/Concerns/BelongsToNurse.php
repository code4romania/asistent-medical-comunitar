<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait BelongsToNurse
{
    public function initializeBelongsToNurse(): void
    {
        $this->fillable[] = 'nurse_id';
    }

    public static function bootBelongsToNurse(): void
    {
        static::addGlobalScope('forCurrentUser', function (Builder $builder) {
            if (! auth()->check()) {
                return;
            }

            $builder->forUser(auth()->user());
        });
    }

    public function nurse(): BelongsTo
    {
        return $this->belongsTo(User::class)->onlyNurses();
    }

    public function scopeForUser(Builder $query, User $user): Builder
    {
        if ($user->isNurse()) {
            return $query->where('nurse_id', $user->id);
        }

        if ($user->isCoordinator()) {
            return $query->whereRelation('nurse', 'activity_county_id', $user->county_id);
        }

        return $query;
    }
}
