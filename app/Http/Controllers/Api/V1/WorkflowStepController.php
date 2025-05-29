<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\V1\WorkflowStep\DestroyWorkflowStepAction;
use App\Actions\V1\WorkflowStep\IndexWorkflowStepAction;
use App\Actions\V1\WorkflowStep\ShowWorkflowStepActionhp;
use App\Actions\V1\WorkflowStep\StoreWorkflowStepAction;
use App\Actions\V1\WorkflowStep\UpdateWorkflowStepAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreWorkflowStepRequest;
use App\Http\Requests\V1\UpdateWorkflowStepRequest;
use App\Http\Resources\V1\WorkflowStepResource;
use App\Models\Workflow;
use App\Models\WorkflowStep;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkflowStepController extends Controller
{
    public function index(Workflow $workflow, IndexWorkflowStepAction $action): JsonResource
    {
        $steps = $action->handle($workflow);

        return WorkflowStepResource::collection($steps);
    }

    public function store(StoreWorkflowStepRequest $request, StoreWorkflowStepAction $action): JsonResource
    {
        $step = $action->handle($request->validated());

        return new WorkflowStepResource($step);
    }

    public function show(Workflow $workflow, WorkflowStep $step, ShowWorkflowStepActionhp $action): JsonResource
    {
        $step = $action->handle($workflow, $step);

        return new WorkflowStepResource($step);
    }

    public function update(UpdateWorkflowStepRequest $request, Workflow $workflow, WorkflowStep $step, UpdateWorkflowStepAction $action): JsonResource
    {
        $step = $action->handle($step, $request->validated());

        return new WorkflowStepResource($step);
    }

    public function destroy(Workflow $workflow, WorkflowStep $step, DestroyWorkflowStepAction $action): JsonResponse
    {
        $action->handle($step);

        return response()->json(status: 204);
    }
}
