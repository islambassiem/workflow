<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\V1\Workflow\IndexWorkflowAction;
use App\Actions\V1\Workflow\ShowWorkflowAction;
use App\Actions\V1\Workflow\StoreWorkflowAction;
use App\Actions\V1\Workflow\UpdateWorkflowAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\WorkflowRequest;
use App\Http\Resources\V1\WorkflowResource;
use App\Models\Workflow;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkflowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexWorkflowAction $action): JsonResource
    {
        $workflows = $action->handle();

        return WorkflowResource::collection($workflows);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(WorkflowRequest $request, StoreWorkflowAction $action): WorkflowResource
    {
        $attributes = $request->validated();

        $workflow = $action->handle($attributes);

        return new WorkflowResource($workflow);
    }

    /**
     * Display the specified resource.
     */
    public function show(Workflow $workflow, ShowWorkflowAction $action): WorkflowResource
    {
        $workflow = $action->handle($workflow);

        return new WorkflowResource($workflow);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WorkflowRequest $request, Workflow $workflow, UpdateWorkflowAction $action): WorkflowResource
    {
        $attributes = $request->validated();

        $updated = $action->handle($workflow, $attributes);

        return new WorkflowResource($updated);
    }
}
