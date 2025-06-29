<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Actions\V1\Admin\Users\IndexUserAction;
use App\Actions\V1\Admin\Users\UserRoleAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRolesRequest;
use App\Http\Resources\V1\UsersResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexUserAction $action, Request $request): mixed
    {
        $users = $request->has('search') ? $action->handle($request->search) : $action->handle();

        return UsersResource::collection($users);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRolesRequest $request, User $user, UserRoleAction $action): JsonResource
    {
        $updatedUser = $action->handle($user, $request->validated());

        return new UsersResource($updatedUser);
    }
}
