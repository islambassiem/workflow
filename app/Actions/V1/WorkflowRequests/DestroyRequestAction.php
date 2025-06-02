<?php

namespace App\Actions\V1\WorkflowRequests;

use App\Models\WorkflowRequest;
use Illuminate\Support\Facades\Gate;

class DestroyRequestAction
{
    public function handle(WorkflowRequest $request): void
    {
        Gate::authorize('delete', $request);

        $request->delete();
    }
}
