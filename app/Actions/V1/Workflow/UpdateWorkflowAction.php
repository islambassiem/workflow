<?php

namespace App\Actions\V1\Workflow;

use App\Models\Workflow;
use Auth;
use Illuminate\Support\Facades\Gate;

class UpdateWorkflowAction
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function handle(Workflow $workflow, array $attributes): Workflow
    {
        Gate::authorize('update_a_workflow', $workflow);

        $attributes['updated_by'] = Auth::id();
        $workflow->update($attributes);

        return $workflow->load('createdBy', 'updatedBy');

    }
}
