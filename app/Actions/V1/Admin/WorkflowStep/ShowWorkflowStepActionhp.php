<?php

namespace App\Actions\V1\Admin\WorkflowStep;

use App\Models\Workflow;
use App\Models\WorkflowStep;
use Illuminate\Support\Facades\Gate;

class ShowWorkflowStepActionhp
{
    public function handle(Workflow $workflow, WorkflowStep $step): WorkflowStep
    {
        Gate::authorize('view_a_workflow_step', $step);

        return WorkflowStep::query()
            ->with(['workflow', 'createdBy', 'updatedBy'])
            ->where('workflow_id', $workflow->id)
            ->first();
    }
}
