<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Actions\V1\Admin\Permission\IndexPermissionAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\PermissionResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexPermissionAction $action): JsonResource
    {
        $permissions = $action->handle();

        return PermissionResource::collection($permissions);
    }
}
