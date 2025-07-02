<?php

namespace App\Actions\V1\WorkflowRequests;

use App\Models\WorkflowRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class UpdateRequestAction
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function handle(WorkflowRequest $request, array $attributes): WorkflowRequest
    {
        Gate::authorize('update', $request);

        $attributes['workflow_id'] = $request->workflow_id;
        $attributes['user_id'] = Auth::id();
        $attributes['status'] = $request->status;
        $attributes['priority'] = $request->priority;

        $request->update($attributes);

        return $request->load('workflow', 'user');
    }
}
