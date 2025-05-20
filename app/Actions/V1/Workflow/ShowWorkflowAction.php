<?php

namespace App\Actions\V1\Workflow;

use App\Models\Workflow;
use Illuminate\Support\Facades\Gate;

class ShowWorkflowAction
{
    public function handle(Workflow $workflow): Workflow
    {
        Gate::authorize('view_workflow', $workflow);

        return $workflow;
    }
}
