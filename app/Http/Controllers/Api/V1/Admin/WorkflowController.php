<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Actions\V1\Admin\Workflow\IndexWorkflowAction;
use App\Actions\V1\Admin\Workflow\ShowWorkflowAction;
use App\Actions\V1\Admin\Workflow\StoreWorkflowAction;
use App\Actions\V1\Admin\Workflow\UpdateWorkflowAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Admin\StoreWorkflowRequest;
use App\Http\Requests\V1\Admin\UpdateWorkflowRequest;
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
    public function store(StoreWorkflowRequest $request, StoreWorkflowAction $action): JsonResource
    {
        $workflow = $action->handle($request->validated());

        return new WorkflowResource($workflow);
    }

    /**
     * Display the specified resource.
     */
    public function show(Workflow $workflow, ShowWorkflowAction $action): JsonResource
    {
        $workflow = $action->handle($workflow);

        return new WorkflowResource($workflow);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Workflow $workflow, UpdateWorkflowRequest $request, UpdateWorkflowAction $action): JsonResource
    {
        $workflow = $action->handle($workflow, $request->validated());

        return new WorkflowResource($workflow);
    }
}
