<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Intervention;
use App\Models\User;

class InterventionPolicy
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
    public function view(User $user, Intervention $intervention): bool
    {
        return $user->isNurse() && $user->beneficiaries->contains('id', $intervention->beneficiary_id);
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
    public function update(User $user, Intervention $intervention): bool
    {
        return $user->isNurse() && $user->beneficiaries->contains('id', $intervention->beneficiary_id);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Intervention $intervention): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Intervention $intervention): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Intervention $intervention): bool
    {
        return false;
    }
}
