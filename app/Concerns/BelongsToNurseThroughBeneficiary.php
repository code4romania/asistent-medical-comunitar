<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

trait BelongsToNurseThroughBeneficiary
{
    public static function bootBelongsToNurseThroughBeneficiary(): void
    {
        static::addGlobalScope('forCurrentUser', function (Builder $builder) {
            if (! auth()->check()) {
                return;
            }

            if (auth()->user()->isAdmin()) {
                return;
            }

            $builder->forUser(auth()->user());
        });
    }

    public function scopeForUser(Builder $query, User $user): Builder
    {
        // This uses the existing beneficiaries scopes
        return $query->whereHas('beneficiary');
    }
}
