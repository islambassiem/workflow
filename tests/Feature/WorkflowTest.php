<?php

use App\Models\User;
use App\Models\Workflow;
use Database\Seeders\UserSeeder;
use Database\Seeders\WorkflowPermissionSeeder;
use Database\Seeders\WorkflowSeeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

describe('authentication', function () {

    test('guest cannot access workflow resource collection', function () {
        $this->seed([UserSeeder::class, WorkflowSeeder::class]);
        $response = $this->getJson(route('workflows.index'));

        $response->assertStatus(401);
    });

    test('guest cannot access a workflow resource', function () {
        $this->seed([UserSeeder::class, WorkflowSeeder::class]);
        $response = $this->getJson(route('workflows.show', 1));

        $response->assertStatus(401);
    });

    test('guest cannot create a workflow', function () {
        $response = $this->postJson(route('workflows.store'), []);

        $response->assertStatus(401);
    });

    test('guest cannot update a workflow', function () {
        $response = $this->putJson(route('workflows.update', 1), []);

        $response->assertStatus(401);
    });
});

describe('authorization', function () {

    test('unauthorized cannot access workflow collection', function () {
        $user = User::factory()->create();
        Workflow::factory()->create();

        $response = $this->actingAs($user)->getJson(route('workflows.index'));

        $response->assertStatus(403);
    });

    test('unauthorized cannot access a workflow resource', function () {
        $user = User::factory()->create();
        $this->seed(WorkflowSeeder::class);

        $response = $this->actingAs($user)->getJson(route('workflows.show', 1));

        $response->assertStatus(403);
    });

    test('unauthorized cannot create a workflow', function () {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson(route('workflows.store'), [
            'name' => 'name',
            'description' => 'description',
        ]);

        $response->assertStatus(403);
    });

    test('unauthorized cannot update a workflow', function () {
        $user = User::factory()->create();
        $this->seed(WorkflowSeeder::class);

        $response = $this->actingAs($user)->putJson(route('workflows.update', 1), [
            'name' => 'name',
            'description' => 'description',
        ]);

        $response->assertStatus(403);
    });
});

describe('authorized users can access workflows', function () {

    test('authorized users can see no content', function () {
        $user = User::factory()->create(['name' => 'admin']);
        $role = Role::create(['name' => 'admin']);
        $user->assignRole($role->name);
        $this->seed(WorkflowPermissionSeeder::class);

        $response = $this->actingAs($user)->getJson(route('workflows.index'));

        $response->assertStatus(200)
            ->assertJsonPath('data', [])
            ->assertJsonPath('data.links.prev', null)
            ->assertJsonPath('data.links.next', null);
    });

    test('authorized users can access workflow collection', function () {
        $this->seed();
        $admin = User::where('name', 'admin')->first();
        $response = $this->actingAs($admin)->getJson(route('workflows.index'));
        $workflow = $response->json('data')[0];
        $perPage = config('app.perPage');

        $response->assertStatus(200)
            ->assertJsonPath('meta.last_page', (int) ceil(config('app.seederCount') / $perPage))
            ->assertJsonCount($perPage, 'data')
            ->assertJsonPath('data.0.id', $workflow['id'])
            ->assertJsonPath('data.0.name', $workflow['name'])
            ->assertJsonPath('data.0.steps_count', $workflow['steps_count'])
            ->assertJsonPath('data.0.updated_at', $workflow['updated_at'])
            ->assertJsonPath('data.0.created_at', $workflow['created_at'])
            ->assertJsonPath('data.0.description', $workflow['description']);
    });

    test('authorized users can show a show a workflow', function () {
        $this->seed();
        $admin = User::where('name', 'admin')->first();

        $workflow = Workflow::find(1);
        $response = $this->actingAs($admin)->getJson(route('workflows.show', 1));

        $response->assertStatus(200)
            ->assertJsonPath('data.id', $workflow->id)
            ->assertJsonPath('data.name', $workflow->name)
            ->assertJsonPath('data.description', $workflow->description);
    });

    test('authorized users can show not found workflow', function () {
        $this->seed();
        $admin = User::where('name', 'admin')->first();

        $workflow = Workflow::find(1);
        $response = $this->actingAs($admin)->getJson(route('workflows.show', 9999));

        $response->assertStatus(404);
    });

    test('authorized user can store a workflow', function () {
        $this->seed();

        $admin = User::where('name', '=', 'admin')->first();

        $response = $this->actingAs($admin)->postJson(route('workflows.store'), [
            'name' => 'title',
            'description' => 'description for the workflow',
        ]);

        $response->assertStatus(201)
            ->assertJsonPath('data.name', 'title')
            ->assertJsonPath('data.description', 'description for the workflow')
            ->assertJsonPath('data.created_by.name', 'admin');
    });

    test('authorized users can update a workflow', function () {
        $this->seed();
        $workflow = Workflow::first();
        $admin = User::where('name', 'admin')->first();

        $response = $this->actingAs($admin)->putJson(route('workflows.update', $workflow->id), [
            'name' => 'title updated',
            'description' => 'description updated',
        ]);
        $workflow->refresh();
        $response->assertStatus(200)
            ->assertJsonPath('data.name', 'title updated')
            ->assertJsonPath('data.description', 'description updated');
    });

    test('assert validation errors', function ($workflows) {
        $this->seed();
        $admin = User::where('name', 'admin')->first();

        $response = $this->actingAs($admin)->postJson(route('workflows.store'), $workflows);

        $response->assertStatus(422);
    })->with([
        [['name' => '', 'description' => '']],
        [['name' => Str::repeat('a', 256), 'description' => Str::repeat('a', 10001)]],
    ]);
});
