<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Actions\V1\Admin\Role\DestroyRoleAction;
use App\Actions\V1\Admin\Role\IndexRoleAction;
use App\Actions\V1\Admin\Role\StoreRoleAction;
use App\Actions\V1\Admin\Role\UpdateRoleAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Admin\StoreRoleRequest;
use App\Http\Requests\V1\Admin\UpdateRoleRequest;
use App\Http\Resources\RoleResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexRoleAction $action): JsonResource
    {
        $roles = $action->handle();

        return RoleResource::collection($roles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request, StoreRoleAction $action): JsonResource
    {
        $role = $action->handle($request->validated());

        return new RoleResource($role);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role, UpdateRoleAction $action): JsonResource
    {
        $role = $action->handle($role, $request->validated());

        return new RoleResource($role);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role, DestroyRoleAction $action): JsonResponse
    {
        $action->handle($role);

        return response()->json(status: 204);
    }
}
