<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\Intervention\EditRestriction;
use App\Models\Intervention;
use App\Models\User;

class InterventionPolicy
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
    public function view(User $user, Intervention $intervention): bool
    {
        if ($user->isMediator()) {
            return $intervention->mediator_has_access;
        }

        return true;
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
     *
     * The reasons an intervention stops being editable have on `EditRestriction`,
     * so the intervention view page can explain the denial to the user.
     */
    public function update(User $user, Intervention $intervention): bool
    {
        return blank(EditRestriction::resolve($intervention, $user));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Intervention $intervention): bool
    {
        if (filled($intervention->parent_id)) {
            return $this->update($user, $intervention->parent);
        }

        if (! $intervention->isOpen()) {
            return false;
        }

        return $this->view($user, $intervention);
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
