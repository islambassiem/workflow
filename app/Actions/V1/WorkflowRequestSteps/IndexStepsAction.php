<?php

namespace App\Actions\V1\WorkflowRequestSteps;

use App\Models\WorkflowRequest;
use App\Models\WorkflowRequestStep;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Gate;

class IndexStepsAction
{
    /**
     * @return LengthAwarePaginator<int, WorkflowRequestStep>
     */
    public function handle(WorkflowRequest $request): LengthAwarePaginator
    {
        Gate::authorize('view', $request);

        return WorkflowRequestStep::where('workflow_request_id', $request->id)
            ->orderBy('order', 'asc')
            ->with(['request', 'step', 'role', 'actionBy'])
            ->paginate(config('app.perPage'));
    }
}
