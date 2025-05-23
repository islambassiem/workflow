<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\V1\Request\IndexRequestAction;
use App\Actions\V1\Request\ShowRequestAction;
use App\Actions\V1\Request\StoreRequestAction;
use App\Actions\V1\Request\UpdateRequestAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\RequestRequest;
use App\Http\Resources\V1\RequestResource;
use App\Models\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RequestController extends Controller
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
    public function store(RequestRequest $request, StoreRequestAction $action): JsonResource
    {
        $request = $action->handle($request->validated());

        return new RequestResource($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, ShowRequestAction $action): JsonResource
    {
        $request = $action->handle($request);

        return new RequestResource($request);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RequestRequest $validation, Request $request, UpdateRequestAction $action): JsonResource
    {
        $request = $action->handle($request, $validation->validated());

        return new RequestResource($request);
    }
}
