<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\V1\Approval\GetRequestsAction;
use App\Actions\V1\Approval\GetStepsAction;
use App\Actions\V1\Approval\TakeActionAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\ApproveStepRequest;
use App\Http\Resources\V1\ApprovalRequestResource;
use App\Http\Resources\V1\RequestStepResource;
use App\Models\WorkflowRequest;
use App\Models\WorkflowRequestStep;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class ApprovalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(GetRequestsAction $action): JsonResource
    {
        $request = $action->handle();

        return ApprovalRequestResource::collection($request);
    }

    public function show(WorkflowRequest $request): JsonResource
    {

        $steps = (new GetStepsAction($request))->handle();

        return RequestStepResource::collection($steps);
    }

    /**
     * Update the specified resource in storage. WorkflowRequestStep
     */
    public function update(ApproveStepRequest $formRequest, WorkflowRequest $request, WorkflowRequestStep $step, TakeActionAction $action): JsonResource
    {
        if ($request->id !== $step->workflow_request_id) {
            abort(404);
        }

        $attributes = $formRequest->validated();
        $attributes['action_by'] = Auth::id();

        $step = $action->handle($step, $attributes);

        return new RequestStepResource($step);
    }
}
