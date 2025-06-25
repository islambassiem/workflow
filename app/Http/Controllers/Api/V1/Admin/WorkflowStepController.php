<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Actions\V1\Admin\WorkflowStep\DestroyWorkflowStepAction;
use App\Actions\V1\Admin\WorkflowStep\IndexWorkflowStepAction;
use App\Actions\V1\Admin\WorkflowStep\ShowWorkflowStepActionhp;
use App\Actions\V1\Admin\WorkflowStep\StoreWorkflowStepAction;
use App\Actions\V1\Admin\WorkflowStep\UpdateWorkflowStepAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Admin\StoreWorkflowStepRequest;
use App\Http\Requests\V1\Admin\UpdateWorkflowStepRequest;
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
        $attributes = $request->validated();

        $workflow_id = $request->route('workflow');
        $order = (Workflow::with('steps')
            ->where('id', $workflow_id)
            ->first()?->steps)
            ->max('order') + 1;

        $attributes['order'] = $order;
        $attributes['workflow_id'] = $workflow_id;

        $step = $action->handle($attributes);

        return new WorkflowStepResource($step);
    }

    public function show(Workflow $workflow, WorkflowStep $step, ShowWorkflowStepActionhp $action): JsonResource
    {
        $step = $action->handle($workflow, $step);

        return new WorkflowStepResource($step);
    }

    public function update(UpdateWorkflowStepRequest $request, Workflow $workflow, WorkflowStep $step, UpdateWorkflowStepAction $action): JsonResource
    {
        // $workflow_id = $request->route('workflow');
        $attributes = $request->validated();
        $attributes['workflow_id'] = $workflow->id;

        $step = $action->handle($step, $attributes);

        return new WorkflowStepResource($step);
    }

    public function destroy(Workflow $workflow, WorkflowStep $step, DestroyWorkflowStepAction $action): JsonResponse
    {
        $action->handle($step);

        return response()->json(status: 204);
    }
}
