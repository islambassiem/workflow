<?php

namespace App\Actions\V1\Admin\WorkflowStep;

use App\Models\Workflow;
use App\Models\WorkflowStep;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Gate;

class IndexWorkflowStepAction
{
    /**
     * @return Collection<int, WorkflowStep>
     */
    public function handle(Workflow $workflow): Collection
    {
        Gate::authorize('view_any_workflow_step', WorkflowStep::class);

        return WorkflowStep::where('workflow_id', $workflow->id)
            ->with(['workflow', 'role', 'createdBy', 'updatedBy'])
            ->orderBy('order')
            ->get();
    }
}
