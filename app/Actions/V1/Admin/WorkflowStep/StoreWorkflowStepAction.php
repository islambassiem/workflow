<?php

namespace App\Actions\V1\Admin\WorkflowStep;

use App\Models\WorkflowStep;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class StoreWorkflowStepAction
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function handle(array $attributes): WorkflowStep
    {
        Gate::authorize('create_a_workflow_step', WorkflowStep::class);

        $attributes['created_by'] = Auth::id();
        $step = WorkflowStep::create($attributes);

        return $step->load(['workflow', 'createdBy', 'updatedBy']);
    }
}
