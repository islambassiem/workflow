<?php

namespace App\Actions\V1\WorkflowStep;

use App\Models\WorkflowStep;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UpdateWorkflowStepAction
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function handle(WorkflowStep $step, array $attributes): WorkflowStep
    {
        Gate::authorize('update_a_workflow_step', $step);

        $attributes['updated_by'] = Auth::id();
        $step->update($attributes);

        return $step->load(['workflow', 'approver', 'createdBy', 'updatedBy']);
    }
}
