<?php

use App\Models\User;

it('cannot show permissions page for unauthenticated users', function () {
    $this->getJson(route('permissions.index'))
        ->assertStatus(401);
});

it('cannot show permissions page for unauthorized users', function () {
    $this->actingAs(User::factory()->create())
        ->getJson(route('permissions.index'))
        ->assertStatus(403);
});

it('can show permissions page for authorized users', function () {
    $this->seed();

    $admin = User::role('admin')->first();

    $this->actingAs($admin)
        ->getJson(route('permissions.index'))
        ->assertStatus(200);
});
