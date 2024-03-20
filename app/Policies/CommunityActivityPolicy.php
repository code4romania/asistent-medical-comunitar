<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\CommunityActivity;
use App\Models\User;

class CommunityActivityPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CommunityActivity $communityActivity): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isNurse();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CommunityActivity $communityActivity): bool
    {
        return $user->isNurse() && $communityActivity->nurse_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CommunityActivity $communityActivity): bool
    {
        return $user->isNurse() && $communityActivity->nurse_id === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CommunityActivity $communityActivity): bool
    {
        return $user->isNurse() && $communityActivity->nurse_id === $user->id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CommunityActivity $communityActivity): bool
    {
        return $user->isNurse() && $communityActivity->nurse_id === $user->id;
    }
}
