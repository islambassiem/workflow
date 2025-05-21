<?php

namespace App\Actions\V1\Step;

use App\Models\Step;
use App\Models\Workflow;
use Illuminate\Support\Facades\Gate;

class ShowStepAction
{
    public function handle(Workflow $workflow, Step $step): Step
    {
        Gate::authorize('view_any_step', $step);

        $step = Step::where('workflow_id', $workflow->id)
            ->where('id', $step->id)
            ->first();

        return $step;
    }
}
