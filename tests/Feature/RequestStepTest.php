<?php

use App\Models\User;
use App\Models\WorkflowRequest;
use App\Models\WorkflowRequestStep;

describe('authentication', function () {

    it('do not allow guest access request steps', function () {
        $response = $this->getJson(route('requests.steps.index', 1));
        $response->assertStatus(401);
    });

    it('does not allow users access others request steps', function () {
        $this->seed();
        $user = User::factory()->create();
        WorkflowRequestStep::factory()->create();

        $response = $this->actingAs($user)->getJson(route('requests.steps.index', 1));

        $response->assertStatus(403);
    });
});

describe('allowed users test', function () {

    test('authorized users can access request steps', function () {
        $this->seed();
        $user = User::factory()->create();
        $request = WorkflowRequest::factory()->create([
            'user_id' => $user->id,
        ]);
        WorkflowRequestStep::factory(2)->create([
            'workflow_request_id' => $request->id,
        ]);
        $response = $this->actingAs($user)->getJson(route('requests.steps.index', $request->id));

        $response->assertStatus(200);
        expect($response['data'][0]['step'])->toBeArray();
        expect($response['data'][0]['step'])->toHaveKeys(['id', 'name', 'description', 'order']);
        expect($response['data'][0]['action_by'])->toBeArray();
        expect($response['data'][0]['action_by'])->toHaveKeys(['id', 'name']);
        expect($response['data'][0]['status'])->toBeEnum();
        expect($response['data'][0]['order'])->toBeLessThanOrEqual($response['data'][1]['order']);
    });
});
