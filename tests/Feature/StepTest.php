<?php

use App\Models\Step;
use App\Models\User;
use App\Models\Workflow;

describe('guest cannot access steps', function () {

    test('guest cannot access steps resouce collection', function () {
        $this->seed();

        $response = $this->getJson(route('workflows.steps.index', 1));

        $response->assertStatus(401);
    });

    test('guest cannot access a step resouce', function () {
        $this->seed();

        $response = $this->getJson(route('workflows.steps.show', ['workflow' => 1, 'step' => 1]));

        $response->assertStatus(401);
    });

    test('guest cannot store a step', function () {
        $this->seed();

        $step = Step::factory()->make()->toArray();
        $response = $this->postJson(route('workflows.steps.store', 1), $step);

        $response->assertStatus(401);
    });

    test('guest cannot update a step', function () {
        $this->seed();

        $step = Step::factory()->make()->toArray();
        $response = $this->putJson(route('workflows.steps.update', ['workflow' => 1, 'step' => 1]), $step);

        $response->assertStatus(401);
    });

    test('guest cannot delete a step', function () {
        $this->seed();

        $step = Step::factory()->make()->toArray();
        $response = $this->deleteJson(route('workflows.steps.destroy', ['workflow' => 1, 'step' => 1]));

        $response->assertStatus(401);
    });
});

describe('unauthorized users cannot access steps', function () {

    test('unauthorized users cannot access steps resouce collection', function () {
        $this->seed();

        $response = $this
            ->actingAs(User::factory()->create())
            ->getJson(route('workflows.steps.index', ['workflow' => 1]));

        $response->assertStatus(403);
    });

    test('unauthorized users cannot access a step resouce ', function () {
        $this->seed();

        $response = $this
            ->actingAs(User::factory()->create())
            ->getJson(route('workflows.steps.show', ['workflow' => 1, 'step' => 1]));

        $response->assertStatus(403);
    });

    test('unauthorized users cannot store a step resouce ', function () {
        $this->seed();

        $step = Step::factory()->make()->toArray();
        $response = $this
            ->actingAs(User::factory()->create())
            ->postJson(route('workflows.steps.store', ['workflow' => 1]), $step);

        $response->assertStatus(403);
    });

    test('unauthorized users cannot update a step resouce ', function () {
        $user = User::factory()->create();
        $workflow = Workflow::factory()->create();
        $step = Step::factory()->for($workflow)->create();

        $response = $this
            ->actingAs($user)
            ->putJson(route('workflows.steps.update', ['workflow' => $workflow->id, 'step' => $step->id]), $step->toArray());

        $response->assertStatus(403);
    });

    test('unauthorized users cannot delete a step resouce ', function () {
        $this->seed();

        $response = $this
            ->actingAs(User::factory()->create())
            ->deleteJson(route('workflows.steps.update', ['workflow' => 1, 'step' => 1]));

        $response->assertStatus(403);
    });
});

describe('authorized users can access steps', function () {

    test('authorized users can access steps resouce collection', function () {
        $this->seed();

        $admin = User::where(['name' => 'admin'])->first();
        $workflow = Workflow::factory()->create();

        $first = Step::factory()->create([
            'workflow_id' => $workflow->id,
            'order' => 3,
        ]);

        $last = Step::factory()->create([
            'workflow_id' => $workflow->id,
            'order' => 5,
        ]);

        $response = $this
            ->actingAs($admin)
            ->getJson(route('workflows.steps.index', ['workflow' => 1]));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data',
                'links',
            ]);

        expect($first->order)->toBeLessThan($last->order);
    });

    test('authorized user can show a single step', function () {
        $this->seed();
        $admin = User::where(['name' => 'admin'])->first();
        $workflow = Workflow::factory()->create();
        $step = Step::factory()->create([
            'workflow_id' => $workflow->id,
        ]);

        $response = $this
            ->actingAs($admin)
            ->getJson(route('workflows.steps.show', ['workflow' => $workflow->id, 'step' => $step->id]));

        $response->assertStatus(200)
            ->assertJsonPath('data.id', $step->id)
            ->assertJsonPath('data.name', $step->name)
            ->assertJsonPath('data.order', $step->order);
    });

    test('authorized user can store a new step', function () {
        $this->seed();
        $admin = User::where(['name' => 'admin'])->first();
        $workflow = Workflow::factory()->create();

        $step = Step::factory()->make()->toArray();
        $step['workflow_id'] = $workflow->id;

        $response = $this
            ->actingAs($admin)
            ->postJson(route('workflows.steps.store', ['workflow' => $workflow->id]), $step);

        $response->assertStatus(201)
            ->assertJsonPath('data.id', 17)
            ->assertJsonPath('data.name', $step['name'])
            ->assertJsonPath('data.order', $step['order']);

        $this->assertDatabaseHas('steps', [
            'name' => $step['name'],
            'order' => $step['order'],
            'workflow_id' => $workflow->id,
        ]);

    });

    test('authorized user can update a step', function () {
        $this->seed();
        $admin = User::where(['name' => 'admin'])->first();
        $workflow = Workflow::factory()->create();
        $step = Step::factory()->create([
            'workflow_id' => $workflow->id,
        ]);

        $step = Step::factory()->make([
            'id' => 1,
        ])->toArray();
        $step['workflow_id'] = $workflow->id;

        $response = $this
            ->actingAs($admin)
            ->putJson(route('workflows.steps.update', ['workflow' => $workflow->id, 'step' => $step['id']]), $step);

        $response->assertStatus(200)
            ->assertJsonPath('data.id', $step['id'])
            ->assertJsonPath('data.name', $step['name'])
            ->assertJsonPath('data.order', $step['order']);

        $this->assertDatabaseHas('steps', [
            'name' => $step['name'],
            'order' => $step['order'],
            'workflow_id' => $workflow->id,
        ]);
    });

    test('validation errors for update', function ($steps) {
        $this->seed();
        $admin = User::where(['name' => 'admin'])->first();
        $workflow = Workflow::factory()->create();
        $step = Step::factory()->make([
            'id' => 1,
            'workflow_id' => $workflow->id,
        ])->toArray();

        $response = $this->actingAs($admin)
            ->putJson(route('workflows.steps.update', ['workflow' => $workflow->id, 'step' => $step['id']]), $steps);

        $response->assertStatus(422);

    })->with([
        [['name' => '', 'order' => '', 'workflow_id' => '', 'created_by' => '', 'updated_by' => '']],
        [['name' => 'name', 'order' => '', 'workflow_id' => '', 'created_by' => '', 'updated_by' => '']],
        [['name' => 'name', 'order' => '2', 'workflow_id' => '', 'created_by' => '', 'updated_by' => '']],
    ]);

    test('validation errors for store', function ($steps) {
        $this->seed();
        $admin = User::where(['name' => 'admin'])->first();
        $workflow = Workflow::factory()->create();
        $step = Step::factory()->make([
            'id' => 1,
            'workflow_id' => $workflow->id,
        ])->toArray();

        $response = $this->actingAs($admin)
            ->postJson(route('workflows.steps.store', ['workflow' => $workflow->id]), $steps);

        $response->assertStatus(422);

    })->with([
        [['name' => '', 'order' => '', 'workflow_id' => '', 'created_by' => '', 'updated_by' => '']],
        [['name' => 'name', 'order' => '', 'workflow_id' => '', 'created_by' => '', 'updated_by' => '']],
        [['name' => 'name', 'order' => '2', 'workflow_id' => '', 'created_by' => '', 'updated_by' => '']],
    ]);

    test('authorized user can delete a step', function () {
        $this->seed();
        $admin = User::where(['name' => 'admin'])->first();
        $workflow = Workflow::factory()->create();
        $step = Step::factory()->create([
            'workflow_id' => $workflow->id,
        ]);

        $response = $this
            ->actingAs($admin)
            ->deleteJson(route('workflows.steps.destroy', ['workflow' => $workflow->id, 'step' => $step->id]));

        $response->assertStatus(204);
    });
});
