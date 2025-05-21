<?php

namespace App\Policies;

use App\Models\Step;
use App\Models\User;

class StepPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_step', Step::class);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Step $step): bool
    {
        return $user->can('view_step', $step);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_step', Step::class);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Step $step): bool
    {
        return $user->can('update_step', $step);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Step $step): bool
    {
        return $user->can('delete_step', $step);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Step $step): bool
    {
        return $user->can('restore_step', $step);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Step $step): bool
    {
        return $user->can('forceDelete_step', $step);
    }
}
