<?php

use App\Models\User;
use App\Models\WorkflowRequest;
use App\Models\WorkflowRequestStep;
use App\Services\V1\StepApproverUserService;
use Spatie\Permission\Models\Role;

test('get the correct head', function () {
    $this->seed();

    $role = Role::where('name', 'head')->first();

    $head = User::factory()->create();
    $user = User::factory()->create([
        'head_id' => $head->id,
    ]);

    $workflowRequest = WorkflowRequest::factory()->create([
        'user_id' => $user->id,
    ]);

    $step = WorkflowRequestStep::factory()->create([
        'workflow_request_id' => $workflowRequest->id,
        'role_id' => $role->id,
    ]);

    $service = new StepApproverUserService($step);
    $approvers = $service->handle();

    expect($user->head_id)->toBe($head->id);
    expect($approvers->count())->toBe(1);
    expect($approvers->first()->id)->toBe($head->id);
});

test('get the correct users for a the role to approve the step', function () {
    $this->seed();

    $requester = User::factory()->create();
    $user1 = User::factory()->create();
    $user2 = User::factory()->create();
    $user3 = User::factory()->create();
    $user4 = User::factory()->create();
    $role = Role::create(['name' => 'test_role']);

    $user1->assignRole($role->name);
    $user2->assignRole($role->name);
    $user3->assignRole($role->name);

    $workflowRequest = WorkflowRequest::factory()->create([
        'user_id' => $requester->id,
    ]);

    $step = WorkflowRequestStep::factory()->create([
        'workflow_request_id' => $workflowRequest->id,
        'role_id' => $role->id,
    ]);

    $service = new StepApproverUserService($step);
    $approvers = $service->handle();

    expect($approvers->count())->toBe(3);
    expect($approvers->contains($user1))->toBeTrue();
    expect($approvers->contains($user2))->toBeTrue();
    expect($approvers->contains($user3))->toBeTrue();
    expect($approvers->contains($user4))->not->toBeTrue();
});
