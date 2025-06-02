<?php

namespace App\Services\V1;

use App\Enums\Status;
use App\Models\WorkflowRequest;
use App\Models\WorkflowRequestStep;
use App\Models\WorkflowStep;
use Illuminate\Database\Eloquent\Collection;

class WorkflowRequestStepService
{
    public function __construct(
        public WorkflowRequest $request
    ) {}

    public function store(): void
    {
        $steps = $this->steps();
        foreach ($steps as $step) {
            WorkflowRequestStep::create([
                'workflow_request_id' => $this->request->id,
                'workflow_step_id' => $step->id,
                'approver_id' => $step->approver_id,
                'status' => Status::PENDING,
            ]);
        }
    }

    /**
     * @return Collection<int, WorkflowStep>
     */
    private function steps(): Collection
    {
        return WorkflowStep::where('workflow_id', $this->request->workflow_id)->get();
    }
}
