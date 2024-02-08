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

            if (auth()->user()->isNurse()) {
                $builder->forNurse(auth()->user());
            }

            if (auth()->user()->isCoordinator()) {
                $builder->forNurseInCounty(auth()->user()->county_id);
            }
        });
    }

    public function nurse(): BelongsTo
    {
        return $this->belongsTo(User::class)->onlyNurses();
    }

    public function scopeForNurse(Builder $query, User $user): Builder
    {
        return $query->whereBelongsTo($user, 'nurse');
    }

    public function scopeForNurseInCounty(Builder $query, int $county_id): Builder
    {
        return $query->whereHas('nurse', function (Builder $query) use ($county_id) {
            $query->activatesInCounty($county_id);
        });
    }
}
