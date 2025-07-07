<?php

namespace App\Actions\V1\Approval;

use App\Models\WorkflowRequestStep;
use Illuminate\Support\Facades\Gate;

class TakeActionAction
{
    /**
     * @param  array<string, string>  $attributes
     */
    public function handle(WorkflowRequestStep $step, array $attributes): WorkflowRequestStep
    {
        Gate::authorize('update', $step);

        $step->update($attributes);

        return $step;
    }
}
