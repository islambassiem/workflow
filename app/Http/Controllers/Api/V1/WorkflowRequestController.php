<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\V1\WorkflowRequests\DestroyRequestAction;
use App\Actions\V1\WorkflowRequests\IndexRequestAction;
use App\Actions\V1\WorkflowRequests\ShowRequestAction;
use App\Actions\V1\WorkflowRequests\StoreRequestAction;
use App\Actions\V1\WorkflowRequestSteps\StoreStepsAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\StoreRequestRequest;
use App\Http\Resources\V1\RequestResource;
use App\Mail\WorkflowRequestMail;
use App\Models\WorkflowRequest;
use App\Services\V1\StepApproverUserService;
use DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class WorkflowRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexRequestAction $action): JsonResource
    {
        $requests = $action->handle();

        return RequestResource::collection($requests);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequestRequest $request, StoreRequestAction $action): JsonResource
    {
        $insertedWorkflowRequest = DB::transaction(function () use ($request, $action) {
            $workflowRequest = $action->handle(Auth::user(), $request->validated());
            (new StoreStepsAction($workflowRequest))->handle();

            return $workflowRequest;
        });

        $firstStep = $insertedWorkflowRequest->load(['steps', 'workflow'])->steps->first();

        $approvers = (new StepApproverUserService($firstStep))->handle();
        Mail::to($approvers)
            ->cc(Auth::user()->email)
            ->send((new WorkflowRequestMail($firstStep, Auth::user()->name))->afterCommit());

        return new RequestResource($insertedWorkflowRequest);
    }

    /**
     * Display the specified resource.
     */
    public function show(WorkflowRequest $request, ShowRequestAction $action): JsonResource
    {
        $request = $action->handle($request);

        return new RequestResource($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkflowRequest $request, DestroyRequestAction $action): JsonResponse
    {
        $action->handle($request);

        return response()->json(status: 204);
    }
}
