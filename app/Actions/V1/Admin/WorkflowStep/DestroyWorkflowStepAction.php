<?php

namespace App\Actions\V1\Admin\WorkflowStep;

use App\Models\WorkflowStep;
use Illuminate\Support\Facades\Gate;

class DestroyWorkflowStepAction
{
    public function handle(WorkflowStep $step): void
    {
        Gate::authorize('destroy_a_workflow_step', $step);

        $step->delete();
    }
}
