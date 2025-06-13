<?php

use App\Models\User;
use App\Models\Workflow;
use App\Models\WorkflowStep;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

describe('authenticaton', function () {

    test('guest users cannot access steps', function () {
        User::factory()->create();
        $workflow = Workflow::factory()->create();

        $response = $this->getJson(route('workflows.steps.index', $workflow->id));

        $response->assertStatus(401);
    });

    test('guest users cannot show a step', function () {
        User::factory()->create();
        Role::create(['name' => 'admin']);
        $workflow = Workflow::factory()->create();
        $step = WorkflowStep::factory()->create();

        $response = $this->getJson(route('workflows.steps.show', [$workflow->id, $step->id]));

        $response->assertStatus(401);
    });

    test('guest users cannot store a step', function () {
        User::factory()->create();
        Role::create(['name' => 'admin']);
        $workflow = Workflow::factory()->create();
        $step = WorkflowStep::factory()->create();

        $response = $this->postJson(
            route('workflows.steps.store', $workflow->id),
            WorkflowStep::factory()->make()->toArray()
        );

        $response->assertStatus(401);
    });

    test('guest users cannot update a step', function () {
        User::factory()->create();
        Role::create(['name' => 'admin']);
        $workflow = Workflow::factory()->create();
        $step = WorkflowStep::factory()->create();

        $response = $this->putJson(
            route('workflows.steps.update', [$workflow->id, $step->id]),
            WorkflowStep::factory()->make()->toArray()
        );

        $response->assertStatus(401);
    });

    test('guest users cannot delete a step', function () {
        User::factory()->create();
        Role::create(['name' => 'admin']);
        $workflow = Workflow::factory()->create();
        $step = WorkflowStep::factory()->create();

        $response = $this->deleteJson(
            route('workflows.steps.destroy', [$workflow->id, $step->id])
        );

        $response->assertStatus(401);
    });
});

describe('authorization', function () {

    test('unathenticatd users cannot access steps', function () {
        $user = User::factory()->create();
        Role::create(['name' => 'admin']);
        $workflow = Workflow::factory()->create();
        $step = WorkflowStep::factory()->create();

        $response = $this->actingAs($user)->getJson(route('workflows.steps.index', $workflow->id));

        $response->assertStatus(403);
    });

    test('unathenticatd users cannot access a step', function () {
        $user = User::factory()->create();
        Role::create(['name' => 'admin']);
        $workflow = Workflow::factory()->create();
        $step = WorkflowStep::factory()->create();

        $response = $this->actingAs($user)->getJson(route('workflows.steps.show', [$workflow->id, $step->id]));

        $response->assertStatus(403);
    });

    test('unathenticatd users cannot store a step', function () {
        $user = User::factory()->create();
        $workflow = Workflow::factory()->create();
        Role::create(['name' => 'admin']);
        $response = $this
            ->actingAs($user)
            ->postJson(
                route('workflows.steps.store', $workflow->id),
                WorkflowStep::factory()->make()->toArray(),
            );

        $response->assertStatus(403);
    });

    test('unathenticatd users cannot update a step', function () {
        $user = User::factory()->create();
        Role::create(['name' => 'admin']);
        $workflow = Workflow::factory()->create();
        $step = WorkflowStep::factory()->create();

        $response = $this
            ->actingAs($user)
            ->putJson(
                route('workflows.steps.update', [$workflow->id, $step->id]),
                WorkflowStep::factory()->make()->toArray(),
            );

        $response->assertStatus(403);
    });

    test('unathenticatd users cannot delete a step', function () {
        $user = User::factory()->create();
        $workflow = Workflow::factory()->create();
        Role::create(['name' => 'admin']);
        $step = WorkflowStep::factory()->create([
            'workflow_id' => $workflow->id,
        ]);

        $response = $this
            ->actingAs($user)
            ->deleteJson(route('workflows.steps.destroy', ['workflow' => $workflow->id, 'step' => $step->id]));

        $response->assertStatus(403);
    });
});

describe('authenticated and authorized users', function () {

    test('can access steps pages', function () {
        $user = User::factory()->create();
        $role = Role::firstOrCreate(['name' => 'admin']);
        $permission = Permission::findOrCreate('view_any_workflow_step');
        $role->givePermissionTo($permission);
        $user->assignRole($role);

        $workflow = Workflow::factory()->create();

        WorkflowStep::factory()->count(3)->create([
            'workflow_id' => $workflow->id,
            'role_id' => $role->id,
            'order' => 1,
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        $response = $this->actingAs($user)->getJson(route('workflows.steps.index', $workflow));

        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'workflow',
                    'name',
                    'description',
                    'order',
                    'role_id',
                    'created_by',
                    'updated_by',
                ],
            ],
            'links',
            'meta',
        ]);

        expect($response['data'])->toHaveCount(3);
    });

    it('returns an empty data array when no workflow steps exist', function () {
        $user = User::factory()->create();
        Permission::create(['name' => 'view_any_workflow_step']);
        $user->givePermissionTo('view_any_workflow_step');
        $workflow = Workflow::factory()->create();

        $response = $this->actingAs($user)->getJson(route('workflows.steps.index', $workflow));

        $response->assertOk()->assertJson([
            'data' => [],
        ]);
    });

    it('shows a single workflow step resource', function () {
        $user = User::factory()->create();
        Permission::findOrCreate('view_a_workflow_step');
        $user->givePermissionTo('view_a_workflow_step');
        $role = Role::firstOrCreate(['name' => 'admin']);
        $user->assignRole('admin');
        $workflow = Workflow::factory()->create();
        $step = WorkflowStep::factory()->create([
            'workflow_id' => $workflow->id,
            'role_id' => $role->id,
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        $response = $this
            ->actingAs($user)
            ->getJson(route('workflows.steps.show', [$workflow->id, $step->id]));

        $response->assertOk()->assertJsonStructure([
            'data' => [
                'id',
                'workflow',
                'name',
                'description',
                'order',
                'role_id',
                'created_by',
                'updated_by',
            ],
        ]);

        expect($response->json('data.id'))->toBe($step->id);
    });

    it('creates a new workflow step successfully', function () {
        $user = User::factory()->create();
        Permission::findOrCreate('create_a_workflow_step');
        $user->givePermissionTo('create_a_workflow_step');
        $role = Role::firstOrCreate(['name' => 'Finance']);
        $workflow = Workflow::factory()->create();
        $payload = [
            'workflow_id' => $workflow->id,
            'name' => 'Initial Approval',
            'description' => 'This is the first step of the workflow.',
            'order' => 1,
            'role_id' => $role->id,
        ];

        $response = $this->actingAs($user)->postJson(
            route('workflows.steps.store', $workflow),
            $payload
        );

        $response->assertCreated()->assertJsonStructure([
            'data' => [
                'id',
                'workflow',
                'name',
                'description',
                'order',
                'role_id',
                'created_by',
                'updated_by',
            ],
        ]);

        expect($response['data']['name'])->toBe('Initial Approval');

        $this->assertDatabaseHas('workflow_steps', [
            'workflow_id' => $workflow->id,
            'name' => 'Initial Approval',
            'role_id' => $role->id,
        ]);
    });

    it('updates a workflow step successfully', function () {
        $user = User::factory()->create();
        Permission::create(['name' => 'update_a_workflow_step']);
        $user->givePermissionTo('update_a_workflow_step');
        $this->actingAs($user);
        $workflow = Workflow::factory()->create();
        $originalRole = Role::create(['name' => 'Finance']);
        $newRole = Role::create(['name' => 'Procurement']);
        $step = WorkflowStep::factory()->create([
            'workflow_id' => $workflow->id,
            'name' => 'Original Step',
            'description' => 'Original description',
            'order' => 1,
            'role_id' => $originalRole->id,
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);
        $updatePayload = [
            'workflow_id' => $workflow->id,
            'name' => 'Updated Step Name',
            'description' => 'Updated step description',
            'order' => 2,
            'role_id' => $newRole->id,
        ];

        $response = $this->putJson(route('workflows.steps.update', [$workflow->id, $step->id]), $updatePayload);

        $response->assertOk()->assertJsonStructure([
            'data' => [
                'id',
                'workflow',
                'name',
                'description',
                'order',
                'role_id',
                'created_by',
                'updated_by',
            ],
        ]);

        expect($response['data']['name'])->toBe('Updated Step Name');
        expect($response['data']['description'])->toBe('Updated step description');
        expect($response['data']['order'])->toBe(2);

        $this->assertDatabaseHas('workflow_steps', [
            'id' => $step->id,
            'name' => 'Updated Step Name',
            'description' => 'Updated step description',
            'order' => 2,
            'role_id' => $newRole->id,
        ]);
    });

    it('deletes a workflow step successfully', function () {
        $user = User::factory()->create();
        $role = Role::firstOrCreate(['name' => 'admin']);
        Permission::findOrCreate('destroy_a_workflow_step');
        $role->givePermissionTo('destroy_a_workflow_step');
        $user->assignRole($role);
        $workflow = Workflow::factory()->create();
        $step = WorkflowStep::factory()->create([
            'workflow_id' => $workflow->id,
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        $response = $this->actingAs($user)->deleteJson(
            route('workflows.steps.destroy', [$workflow->id, $step->id])
        );

        $response->assertNoContent();

        $this->assertDatabaseMissing('workflow_steps', [
            'id' => $step->id,
        ]);
    });

    beforeEach(function () {
        $this->user = User::factory()->create();
        Permission::create(['name' => 'create_a_workflow_step']);
        $this->user->givePermissionTo('create_a_workflow_step');
        $this->actingAs($this->user);
        $this->workflow = Workflow::factory()->create();
    });

    dataset('invalid workflow step data', [
        'missing name' => [
            ['name' => null],
            'name',
        ],
        'too long name' => [
            ['name' => str_repeat('a', 256)],
            'name',
        ],
        'non-existent workflow' => [
            ['workflow_id' => 9999],
            'workflow_id',
        ],
        'non-integer order' => [
            ['order' => 'first'],
            'order',
        ],
        'description too long' => [
            ['description' => str_repeat('x', 1001)],
            'description',
        ],
    ]);

    it('fails validation with invalid data', function (array $override, string $expectedInvalidField) {
        $validPayload = [
            'workflow_id' => $this->workflow->id,
            'name' => 'Step A',
            'description' => 'Optional desc',
            'order' => 1,
            'role_id' => 1,
        ];

        $payload = array_merge($validPayload, $override);

        $response = $this->postJson(route('workflows.steps.store', $this->workflow), $payload);

        // Assert validation fails
        $response->assertStatus(422);
        $response->assertJsonValidationErrors($expectedInvalidField);
    })->with('invalid workflow step data');

    beforeEach(function () {
        $user = User::factory()->create();
        Role::create(['name' => 'admin']);
        $user->assignRole('admin');
        $this->actingAs($this->user);

        $this->workflow = Workflow::factory()->create();

        $this->step = WorkflowStep::factory()->create([
            'workflow_id' => $this->workflow->id,
            'name' => 'Valid Step',
            'description' => 'Valid desc',
            'order' => 1,
            'role_id' => 1,
            'created_by' => $this->user->id,
            'updated_by' => $this->user->id,
        ]);
    });

    dataset('invalid update step data', [
        'missing name' => [
            ['name' => null],
            'name',
        ],
        'too long name' => [
            ['name' => str_repeat('x', 256)],
            'name',
        ],
        'non-existent workflow' => [
            ['workflow_id' => 9999],
            'workflow_id',
        ],
        'non-integer order' => [
            ['order' => 'abc'],
            'order',
        ],
        'non-integer approver_id' => [
            ['role_id' => 'string'],
            'role_id',
        ],
        'description too long' => [
            ['description' => str_repeat('y', 1001)],
            'description',
        ],
    ]);

    it('fails to update workflow step with invalid data', function (array $override, string $invalidField) {
        $validPayload = [
            'workflow_id' => $this->workflow->id,
            'name' => 'Updated Name',
            'description' => 'Updated desc',
            'order' => 2,
            'role_id' => 1,
        ];

        $payload = array_merge($validPayload, $override);
        $response = $this->putJson(route('workflows.steps.update', [$this->workflow->id, $this->step->id]), $payload);

        $response->assertStatus(403);

    })->with('invalid update step data');
});
