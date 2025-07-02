<?php

namespace App\Actions\V1\WorkflowRequests;

use App\Models\WorkflowRequest;
use Illuminate\Support\Facades\Gate;

class ShowRequestAction
{
    public function handle(WorkflowRequest $request): WorkflowRequest
    {
        Gate::authorize('view', $request);

        return $request->load('workflow', 'user')->loadCount('steps');
    }
}
