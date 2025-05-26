<?php

use App\Http\Controllers\Api\V1\LoginController;
use App\Http\Controllers\Api\V1\LogoutController;
use App\Http\Controllers\Api\V1\WorkflowController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login', LoginController::class)->name('login');
Route::middleware('auth:sanctum')->post('logout', LogoutController::class)->name('logout');

Route::apiResource('workflows', WorkflowController::class)
    ->except('destroy')
    ->middleware('auth:sanctum');
