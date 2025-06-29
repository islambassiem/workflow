<?php

use App\Models\User;

describe('authentication', function () {

    it('does not allow guest users accessing users page', function () {

        $response = $this->getJson(route('users.index'));

        $response->assertStatus(401);
    });

    it('does not allow guest users editing user roles', function () {

        $response = $this->putJson(route('users.update', 1), []);

        $response->assertStatus(401);
    });
});

describe('authorization', function () {

    it('does not allow unathorized users accessing users page', function () {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson(route('users.index'));

        $response->assertStatus(403);
    });

    it('does not allow unathorized users editing user roles', function () {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->putJson(route('users.update', 1), []);

        $response->assertStatus(403);
    });
});

describe('authorized users', function () {

    it('allow authorized users to access users page', function () {
        $this->seed();
        $admin = User::with('roles')->role('admin')->first();
        $response = $this->actingAs($admin)->getJson(route('users.index'));

        $response->assertStatus(200);

        expect($response['data']['0']['name'])->toBe($admin->name);
        expect($response['data']['0']['roles'])->toBeArray();
    });

    it('allow authorized users to update user roles', function () {
        $this->seed();
        $admin = User::role('admin')->first();

        $response = $this->actingAs($admin)->putJson(route('users.update', 2), ['roles' => [5]]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('model_has_roles', [
            'role_id' => 5,
            'model_id' => 2,
        ]);

        $this->assertDatabaseMissing('model_has_roles', [
            'role_id' => 3,
            'model_id' => 2,
        ]);
    });
});
