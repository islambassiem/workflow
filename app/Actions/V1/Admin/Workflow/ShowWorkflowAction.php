<?php

namespace App\Actions\V1\Admin\Workflow;

use App\Models\Workflow;
use Illuminate\Support\Facades\Gate;

class ShowWorkflowAction
{
    public function handle(Workflow $workflow): Workflow
    {
        Gate::authorize('view_a_workflow', $workflow);

        return $workflow->load('createdBy', 'updatedBy');
    }
}
