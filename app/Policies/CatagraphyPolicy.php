<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Catagraphy;
use App\Models\User;

class CatagraphyPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isNurse();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Catagraphy $catagraphy): bool
    {
        return $user->isNurse() && $catagraphy->beneficiary->nurse_id === $user->id;
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
    public function update(User $user, Catagraphy $catagraphy): bool
    {
        return $user->isNurse() && $catagraphy->beneficiary->nurse_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Catagraphy $catagraphy): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Catagraphy $catagraphy): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Catagraphy $catagraphy): bool
    {
        return false;
    }
}
