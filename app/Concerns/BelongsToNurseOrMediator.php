<?php

declare(strict_types=1);

namespace App\Concerns;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

trait BelongsToNurseOrMediator
{
    use BelongsToNurse;
    use BelongsToMediator;

    public static function bootBelongsToNurseOrMediator(): void
    {
        static::addGlobalScope('forCurrentUser', function (Builder $builder) {
            if (! auth()->check()) {
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

    public function scopeForCoordinator(Builder $query, User $user): Builder
    {
        return $query->where(
            fn (Builder $query): Builder => $query
                ->whereRelation('nurse', 'activity_county_id', $user->county_id)
                ->orWhereRelation('mediator', 'activity_county_id', $user->county_id)
        );
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public static function assignOwnerFromAuth(array $data): array
    {
        $user = auth()->user();

        if ($user?->isNurse()) {
            $data['nurse_id'] = $user->id;
        }

        if ($user?->isMediator()) {
            $data['mediator_id'] = $user->id;
        }

        return $data;
    }
}
