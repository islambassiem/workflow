<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\V1\WorkflowRequestSteps\IndexStepsAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\RequestStepResource;
use App\Models\WorkflowRequest;
use Illuminate\Http\Resources\Json\JsonResource;

class RequestStepController extends Controller
{
    public function index(WorkflowRequest $request, IndexStepsAction $action): JsonResource
    {
        $steps = $action->handle($request);

        return RequestStepResource::collection($steps);
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //     //
    // }

    /**
     * Update the specified resource in storage.
     */
    // public function update(Request $request, string $id)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(string $id)
    // {
    //     //
    // }
}
