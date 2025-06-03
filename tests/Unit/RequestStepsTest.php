<?php

use App\Actions\V1\WorkflowRequestSteps\StoreStepsAction;
use App\Models\WorkflowRequest;
use App\Models\WorkflowRequestStep;
use Database\Seeders\UserSeeder;
use Database\Seeders\WorkflowSeeder;
use Database\Seeders\WorkflowStepSeeder;
use Spatie\Permission\Models\Role;

test('making a request make fill the relevant steps', function () {
    Role::create(['name' => 'admin']);
    $this->seed([UserSeeder::class, WorkflowSeeder::class, WorkflowStepSeeder::class]);
    $request = WorkflowRequest::factory()->create();
    (new StoreStepsAction($request))->handle();

    $steps = WorkflowRequestStep::all();

    expect($steps)->not->toBeNull();
});
