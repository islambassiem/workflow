<?php

namespace App\Actions\V1\WorkflowRequestSteps;

use App\Models\WorkflowRequest;
use App\Models\WorkflowRequestStep;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Gate;

class IndexStepsAction
{
    /**
     * @return Collection<int, WorkflowRequestStep>
     */
    public function handle(WorkflowRequest $request): Collection
    {
        Gate::authorize('view', $request);

        return WorkflowRequestStep::where('workflow_request_id', $request->id)
            ->orderBy('order', 'asc')
            ->with(['request', 'step', 'role', 'actionBy'])
            ->get();
    }
}
