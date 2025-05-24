<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\V1\Approval\IndexApprovalAction;
use App\Actions\V1\Approval\ShowApprovalAction;
use App\Actions\V1\Approval\StoreApprovalAction;
use App\Actions\V1\Approval\UpdateApprovalAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\ApprovalRequest;
use App\Http\Resources\V1\ApprovalResource;
use App\Models\Approval;
use App\Models\Request as ModelsRequest;
use Illuminate\Http\Resources\Json\JsonResource;

class ApprovalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ModelsRequest $request, IndexApprovalAction $action): JsonResource
    {
        $approvals = $action->handle($request);

        return ApprovalResource::collection($approvals);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ApprovalRequest $request, StoreApprovalAction $action): JsonResource
    {
        $approval = $action->handle($request->validated());

        return new ApprovalResource($approval);
    }

    /**
     * Display the specified resource.
     */
    public function show(Approval $approval, ShowApprovalAction $action): JsonResource
    {
        $approval = $action->handle($approval);

        return new ApprovalResource($approval);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ApprovalRequest $validation, ModelsRequest $request, Approval $approval ,UpdateApprovalAction $action): JsonResource
    {
        $approval = $action->handle($approval, $validation->validated());

        return new ApprovalResource($approval);
    }
}
