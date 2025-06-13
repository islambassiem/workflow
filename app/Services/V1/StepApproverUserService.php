<?php

namespace App\Services\V1;

use App\Models\User;
use App\Models\WorkflowRequestStep;
use Illuminate\Support\Collection;

class StepApproverUserService
{
    /**
     * Create a new class instance.
     */
    public function __construct(public WorkflowRequestStep $step)
    {
        //
    }

    /**
     * Get the users who can approve the step.
     *
     * @return Collection<int, User>
     */
    public function handle(): Collection
    {
        $step = $this->step->load(['role']);

        if ($step->role->name === 'head') {
            $head = $step->request->user->load('head')->head;

            return $head ? collect([$head]) : collect();
        }

        return User::role($step->role->name)->get();
    }
}
