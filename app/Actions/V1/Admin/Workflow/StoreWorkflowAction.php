<?php

namespace App\Actions\V1\Admin\Workflow;

use App\Models\Workflow;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class StoreWorkflowAction
{
    /**
     * @param  array<string, mixed>  $attributes
     */
    public function handle(array $attributes): Workflow
    {
        Gate::authorize('create_a_workflow', Workflow::class);

        $attributes['created_by'] = Auth::id();
        $workflow = Workflow::create($attributes);

        return $workflow->load('createdBy', 'updatedBy');
    }
}
