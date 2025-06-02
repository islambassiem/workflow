<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WorkflowRequest;

class WorkflowRequestPolicy
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
    public function view(User $user, WorkflowRequest $workflowRequest): bool
    {
        $owns_request = $user->id === $workflowRequest->user_id;

        return $owns_request;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, WorkflowRequest $workflowRequest): bool
    {
        $owns_request = $user->id === $workflowRequest->user_id;

        return $owns_request;
    }
}
