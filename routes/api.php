<?php

use App\Http\Controllers\Api\V1\Admin\PermissionController;
use App\Http\Controllers\Api\V1\Admin\RolesController;
use App\Http\Controllers\Api\V1\Admin\WorkflowController;
use App\Http\Controllers\Api\V1\Admin\WorkflowStepController;
use App\Http\Controllers\Api\V1\LoginController;
use App\Http\Controllers\Api\V1\LogoutController;
use App\Http\Controllers\Api\V1\WorkflowRequestController;
use App\Http\Resources\V1\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return new UserResource($request->user()->load(['roles', 'head']));
})->middleware('auth:sanctum');

Route::post('login', LoginController::class)->name('login');
Route::middleware('auth:sanctum')->post('logout', LogoutController::class)->name('logout');

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('workflows', WorkflowController::class)->except('destroy');
    Route::apiResource('workflows.steps', WorkflowStepController::class);
    Route::apiResource('requests', WorkflowRequestController::class)->except('update');
    Route::apiResource('roles', RolesController::class);
    Route::apiResource('permissions', PermissionController::class)->only('index');
});
