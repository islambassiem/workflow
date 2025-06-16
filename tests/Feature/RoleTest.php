<?php

use App\Models\User;
use Database\Seeders\RoleSeeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

describe('authentication', function () {

    test('guests cannot access roles', function () {
        $this->seed(RoleSeeder::class);

        $response = $this->getJson(route('roles.index'));

        $response->assertStatus(401);
    });

    test('guests cannot store a role', function () {
        $role = Role::make([
            'name' => 'role',
            'name_ar' => 'role in Arabic',
        ])->toArray();

        $response = $this->postJson(route('roles.store'), $role);

        $response->assertStatus(401);
    });

    test('guests cannot update a role', function () {
        Role::create(['name' => 'admin']);
        $role = Role::make([
            'name' => 'updated role',
            'name_ar' => 'updated role in Arabic',
        ])->toArray();

        $response = $this->putJson(route('roles.update', 1), $role);

        $response->assertStatus(401);
    });

    test('guests cannot delete a role', function () {
        Role::create(['name' => 'admin']);

        $response = $this->deleteJson(route('roles.destroy', 1));

        $response->assertStatus(401);
    });
});

describe('authorization', function () {

    test('unauthorized users cannot access roles', function () {
        $this->seed(RoleSeeder::class);
        $user = User::factory()->create();
        $response = $this->actingAs($user)->getJson(route('roles.index'));

        $response->assertStatus(403);
    });

    test('unauthorized users cannot store a role', function () {
        $role = Role::make([
            'name' => 'role',
            'name_ar' => 'role in Arabic',
        ])->toArray();
        $user = User::factory()->create();

        $response = $this->actingAs($user)->postJson(route('roles.store'), $role);

        $response->assertStatus(403);
    });

    test('unauthorized users cannot update a role', function () {
        Role::create(['name' => 'admin']);
        $user = User::factory()->create();
        $role = Role::make([
            'name' => 'updated role',
            'name_ar' => 'updated role in Arabic',
        ])->toArray();

        $response = $this->actingAs($user)->putJson(route('roles.update', 1), $role);

        $response->assertStatus(403);
    });

    test('unauthorized users cannot delete a role', function () {
        Role::create(['name' => 'admin']);
        $user = User::factory()->create();
        $response = $this->actingAs($user)->deleteJson(route('roles.destroy', 1));

        $response->assertStatus(403);
    });
});

describe('authenticated and authorized users', function () {

    test('authorized and authenticated users can access roles page', function () {
        $this->seed();
        $admin = User::role('admin')->first();
        $role = Role::first();

        $response = $this->actingAs($admin)->getJson(route('roles.index'));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'meta',
                'links',
            ]);

        expect($response['data'][0]['id'])->toBe($role->id);
        expect($response['data'][0]['name'])->toBe($role->name);
        expect($response['data'][0]['name_ar'])->toBe($role->name_ar);
    });

    test('authenticated and auhtorized users can store a role', function () {
        $this->seed();
        $admin = User::role('admin')->first();
        $role = Role::make([
            'name' => 'role',
            'name_ar' => 'role in Arabic',
        ])->toArray();

        $response = $this->actingAs($admin)->postJson(route('roles.store'), $role);

        $response->assertStatus(201);
        $this->assertDatabaseHas('roles', [
            'name' => $role['name'],
            'name_ar' => $role['name_ar'],
        ]);

        expect($response['data']['name'])->toBe($role['name']);
        expect($response['data']['name_ar'])->toBe($role['name_ar']);
    });

    test('authenticated and authorized users can update a role', function () {
        $this->seed();
        $admin = User::role('admin')->first();
        $role = Role::make([
            'name' => 'updated role',
            'name_ar' => 'updated role in Arabic',
        ])->toArray();

        $response = $this->actingAs($admin)->putJson(route('roles.update', 1), $role);

        $response->assertStatus(200);
        $this->assertDatabaseHas('roles', [
            'name' => 'updated role',
            'name_ar' => 'updated role in Arabic',
        ]);

        expect($response['data']['name'])->toBe($role['name']);
        expect($response['data']['name_ar'])->toBe($role['name_ar']);
    });

    test('authenticated and authorized users cannot delete a referenced role', function () {
        $this->seed();
        $admin = User::role('admin')->first();

        $response = $this->actingAs($admin)->deleteJson(route('roles.destroy', Role::first()));

        $response->assertStatus(422)
            ->assertJsonStructure([
                'errors' => ['role'],
            ]);
    });

    test('authenticated and authorized users can delete a non-referenced role', function () {
        $admin = User::factory()->create();
        User::factory()->count(5)->create();
        $role = Role::create(['name' => 'admin']);
        $admin->assignRole('admin');
        $permission = Permission::create(['name' => 'delete_a_role']);
        $permission->assignRole('admin');

        for ($i = 2; $i <= 6; $i++) {
            DB::table('model_has_roles')->insert([
                'role_id' => $role->id,
                'model_type' => 'App\Models\User',
                'model_id' => $i,
            ]);
        }

        $this->assertDatabaseHas('roles', [
            'name' => $role->name,
        ])->assertDatabaseCount('model_has_roles', 6);

        $response = $this->actingAs($admin)->deleteJson(route('roles.destroy', $role->id));

        $response->assertStatus(204);

        $this
            ->assertDatabaseEmpty('roles')
            ->assertDatabaseMissing('model_has_roles', ['role_id' => $role->id]);
    });

});
