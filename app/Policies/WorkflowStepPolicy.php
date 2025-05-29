<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WorkflowStep;

class WorkflowStepPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('view_any_workflow_step', WorkflowStep::class);
    }

    public function view(User $user, WorkflowStep $workflowStep): bool
    {
        return $user->can('view_a_workflow_step', $workflowStep);
    }

    public function create(User $user): bool
    {
        return $user->can('create_a_workflow_step', WorkflowStep::class);
    }

    public function update(User $user, WorkflowStep $workflowStep): bool
    {
        return $user->can('update_a_workflow_step', $workflowStep);
    }

    public function destroy(User $user, WorkflowStep $workflowStep): bool
    {
        return $user->can('destroy_a_workflow_step', $workflowStep);
    }
}
