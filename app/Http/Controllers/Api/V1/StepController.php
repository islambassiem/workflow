<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\V1\Step\DestroyStepAction;
use App\Actions\V1\Step\IndexStepAction;
use App\Actions\V1\Step\ShowStepAction;
use App\Actions\V1\Step\StoreStepAction;
use App\Actions\V1\Step\UpdateStepAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\StepRequest;
use App\Http\Resources\V1\StepResource;
use App\Models\Step;
use App\Models\Workflow;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class StepController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Workflow $workflow, IndexStepAction $action): JsonResource
    {
        $steps = $action->handle($workflow);

        return StepResource::collection($steps);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StepRequest $request, StoreStepAction $action): StepResource
    {
        $step = $action->handle($request->validated());

        return new StepResource($step);
    }

    /**
     * Display the specified resource.
     */
    public function show(Workflow $workflow, Step $step, ShowStepAction $action): JsonResource
    {
        $step = $action->handle($workflow, $step);

        return new StepResource($step);
    }

    public function update(StepRequest $request, Workflow $workflow, Step $step, UpdateStepAction $action): JsonResource
    {
        $step = $action->handle($step, $request->validated());

        return new StepResource($step);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Workflow $workflow, Step $step, DestroyStepAction $action): JsonResponse
    {
        $action->handle($step);

        return response()->json(status: 204);
    }
}
