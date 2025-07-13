<?php

use App\Http\Controllers\Api\V1\Admin\PermissionController;
use App\Http\Controllers\Api\V1\Admin\RolesController;
use App\Http\Controllers\Api\V1\Admin\UserController;
use App\Http\Controllers\Api\V1\Admin\WorkflowController;
use App\Http\Controllers\Api\V1\Admin\WorkflowStepController;
use App\Http\Controllers\Api\V1\ApprovalController;
use App\Http\Controllers\Api\V1\LoginController;
use App\Http\Controllers\Api\V1\LogoutController;
use App\Http\Controllers\Api\V1\RequestStepController;
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
    Route::get('workflows-list', [WorkflowController::class, 'list'])->name('workflows.list');
    Route::apiResource('workflows.steps', WorkflowStepController::class);
    Route::apiResource('requests', WorkflowRequestController::class)->except('update');
    Route::apiResource('requests.steps', RequestStepController::class)->only('index');
    Route::group(['prefix' => 'approvals'], function () {
        Route::get('requests', [ApprovalController::class, 'index'])->name('approvals.index');
        Route::get('requests/{request}/steps', [ApprovalController::class, 'show'])->name('approvals.show');
        Route::post('requests/{request}/steps/{step}/action', [ApprovalController::class, 'update'])->name('approvals.update');
    });
    Route::apiResource('roles', RolesController::class);
    Route::apiResource('permissions', PermissionController::class)->only('index');
    Route::apiResource('users', UserController::class)->only('index', 'update');
});
