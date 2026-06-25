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
        return $user->isNurseOrMediator();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CommunityActivity $communityActivity): bool
    {
        if ($user->isNurse()) {
            return $communityActivity->nurse_id === $user->id;
        }

        if ($user->isMediator()) {
            return $communityActivity->mediator_id === $user->id;
        }

        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CommunityActivity $communityActivity): bool
    {
        return $this->update($user, $communityActivity);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CommunityActivity $communityActivity): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CommunityActivity $communityActivity): bool
    {
        return false;
    }
}
