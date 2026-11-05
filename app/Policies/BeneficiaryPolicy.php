<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Beneficiary;
use App\Models\User;

class BeneficiaryPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->isNurseOrMediator();
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Beneficiary $beneficiary): bool
    {
        if ($user->isNurse()) {
            return $beneficiary->nurse_id === $user->id;
        }

        if ($user->isMediator()) {
            return $beneficiary->mediator_id === $user->id;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $this->viewAny($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Beneficiary $beneficiary): bool
    {
        return $this->view($user, $beneficiary);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Beneficiary $beneficiary): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Beneficiary $beneficiary): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Beneficiary $beneficiary): bool
    {
        return false;
    }
}
