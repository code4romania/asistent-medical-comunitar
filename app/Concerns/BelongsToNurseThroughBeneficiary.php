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
        return match (true) {
            $user->isNurse() => $query->forNurse($user),
            $user->isMediator() => $query->forMediator($user),
            $user->isCoordinator() => $query->forCoordinator($user),
            $user->isAdmin() => $query,
        };
    }

    public function scopeForNurse(Builder $query, User $user): Builder
    {
        return $query->whereRelation('beneficiary', 'nurse_id', $user->id);
    }

    public function scopeForMediator(Builder $query, User $user): Builder
    {
        return $query->where(
            fn (Builder $query): Builder => $query
                ->whereRelation('beneficiary', 'mediator_id', $user->id)
                ->when(
                    $this->isFillable('mediator_has_access'),
                    fn (Builder $query): Builder => $query->where('mediator_has_access', true)
                )
        );
    }

    public function scopeForCoordinator(Builder $query, User $user): Builder
    {
        return $query->where(
            fn (Builder $query): Builder => $query
                ->whereRelation('beneficiary.nurse', 'activity_county_id', $user->county_id)
                ->orWhereRelation('beneficiary.mediator', 'activity_county_id', $user->county_id)
        );
    }
}
