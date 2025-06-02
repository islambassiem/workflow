<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Workflow;

class WorlflowPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_workflow', Workflow::class);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Workflow $workflow): bool
    {
        return $user->can('view_a_workflow', $workflow);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create_a_workflow', Workflow::class);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Workflow $workflow): bool
    {
        return $user->can('update_a_workflow', $workflow);
    }
}
