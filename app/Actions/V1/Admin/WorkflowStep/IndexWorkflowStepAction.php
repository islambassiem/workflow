<?php

namespace App\Actions\V1\Admin\WorkflowStep;

use App\Models\Workflow;
use App\Models\WorkflowStep;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Gate;

class IndexWorkflowStepAction
{
    /**
     * @return \Illuminate\Pagination\LengthAwarePaginator<int, WorkflowStep>
     */
    public function handle(Workflow $workflow): LengthAwarePaginator
    {
        Gate::authorize('view_any_workflow_step', WorkflowStep::class);

        return WorkflowStep::where('workflow_id', $workflow->id)
            ->with(['workflow', 'role', 'createdBy', 'updatedBy'])
            ->orderBy('order')
            ->paginate(config('app.perPage'));
    }
}
