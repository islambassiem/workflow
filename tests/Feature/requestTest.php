<?php

use App\Models\Request;
use App\Models\User;
use App\Models\Workflow;

describe('guest cannot access requests', function () {

    test('guest cannot access requests', function () {
        $response = $this->getJson(route('requests.index'));

        $response->assertStatus(401);
    });

    test('guest cannot access a request', function () {
        $this->seed();
        $response = $this->getJson(route('requests.show', 1));

        $response->assertStatus(401);
    });

    test('guest cannot store a request', function () {
        $user = User::factory()->create();
        Workflow::factory()->create();
        $request = Request::factory()->make([
            'id' => 1,
            'user_id' => $user->id,
        ]);
        $response = $this->postJson(route('requests.store'), $request->toArray());

        $response->assertStatus(401);
    });

    test('guest cannot update a request', function () {
        $user = User::factory()->create();
        Workflow::factory()->create();
        $request = Request::factory()->create([
            'id' => 1,
            'user_id' => $user->id,
        ]);
        $response = $this->putJson(route('requests.update', 1), $request->toArray());

        $response->assertStatus(401);
    });

});

describe('authenticated users can access requests', function () {

    test('authorized users can access requests', function () {
        $user = User::factory()->create();
        $workflow = Workflow::factory()->create();
        $request = Request::factory()->create();

        $response = $this->actingAs($user)->getJson(route('requests.index'));

        $response->assertStatus(200)
            ->assertJsonPath('data.0.id', $request->id)
            ->assertJsonPath('data.0.status', $request->status->label())
            ->assertJsonPath('data.0.workflow.name', $workflow->name)
            ->assertJsonPath('data.0.user.id', $user->id);
    });

    test('authorized users can access a request', function () {
        $user = User::factory()->create();
        $workflow = Workflow::factory()->create();
        $request = Request::factory()->create();

        $response = $this->actingAs($user)->getJson(route('requests.show', $request->id));

        $response->assertStatus(200)
            ->assertJsonPath('id', $request->id)
            ->assertJsonPath('status', $request->status->label())
            ->assertJsonPath('workflow.name', $workflow->name)
            ->assertJsonPath('user.id', $user->id);
    });

    test('authenticated users can store a request', function () {
        $user = User::factory()->create();
        $workflow = Workflow::factory()->create();
        $request = Request::factory()->make([
            'id' => 1,
            'workflow_id' => $workflow->id,
            'user_id' => $user->id,
        ]);
        $response = $this->actingAs($user)->postJson(route('requests.store'), $request->toArray());

        $response->assertStatus(201);
        $this->assertDatabaseCount('requests', 1);
    });

    test('authenticated users can update a request', function () {
        $user = User::factory()->create();
        $workflow = Workflow::factory()->create();
        $request = Request::factory()->create();

        $response = $this->actingAs($user)->putJson(route('requests.update', $request->id), [
            'status' => 10,
            'data' => json_encode(['foo' => 'bar']),
            'workflow_id' => $workflow->id,
            'user_id' => $user->id,
        ]);
        $request->refresh();

        $response->assertStatus(200)
            ->assertJsonPath('id', $request->id)
            ->assertJsonPath('status', $request->status->label())
            ->assertJsonPath('workflow.name', $workflow->name)
            ->assertJsonPath('user.id', $user->id);
    });

    test('validation errors', function ($requests) {
        $user = User::factory()->create();
        $workflow = Workflow::factory()->create();
        $request = Request::factory()->make([
            'id' => 1,
            'workflow_id' => $workflow->id,
            'user_id' => $user->id,
        ]);
        $response = $this->actingAs($user)->postJson(route('requests.store'), $requests);

        $response->assertStatus(422);
    })
        ->with([
            [['workflow_id' => '', 'user_id' => '', 'status' => '', 'data' => '']],
            [['workflow_id' => '1', 'user_id' => '', 'status' => '', 'data' => '']],
            [['workflow_id' => '1', 'user_id' => '', 'status' => '2', 'data' => '']],
            [['workflow_id' => '1', 'user_id' => '', 'status' => '2', 'data' => json_encode(['foo' => 'bar'])]],
        ]);
});
