<?php

namespace App\Actions\V1\WorkflowRequestSteps;

use App\Enums\Status;
use App\Models\WorkflowRequest;
use App\Models\WorkflowRequestStep;
use App\Models\WorkflowStep;

class StoreStepsAction
{
    public function __construct(
        public WorkflowRequest $request
    ) {}

    public function handle(): void
    {
        $steps = WorkflowStep::where('workflow_id', $this->request->workflow_id)->get();
        foreach ($steps as $step) {
            WorkflowRequestStep::create([
                'workflow_request_id' => $this->request->id,
                'workflow_step_id' => $step->id,
                'order' => $step->order,
                'approver_type' => $step->approver_type,
                'approver_id' => $step->approver_id,
                'status' => Status::PENDING,
            ]);
        }
    }
}
