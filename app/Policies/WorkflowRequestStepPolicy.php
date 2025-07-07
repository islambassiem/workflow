<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WorkflowRequestStep;

class WorkflowRequestStepPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, WorkflowRequestStep $step): bool
    {
        $user_id = $step->load('step')->request->user_id;

        return $user->id === $user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, WorkflowRequestStep $step): bool
    {

        $step->load(['role', 'request.user']);

        if ($step->role->name === 'head') {
            return $step->request->user->head_id === $user->id || $user->hasRole($step->role->name);
        }

        return $user->hasRole($step->role->name);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, WorkflowRequestStep $workflowRequestStep): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, WorkflowRequestStep $workflowRequestStep): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, WorkflowRequestStep $workflowRequestStep): bool
    {
        return false;
    }
}
