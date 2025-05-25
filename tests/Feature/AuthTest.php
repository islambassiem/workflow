<?php

use App\Models\User;
use Illuminate\Testing\Fluent\AssertableJson;

test('guest can log in successfully', function () {

    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password'),
    ]);

    $response = $this->postJson(route('login'), [
        'email' => 'test@example.com',
        'password' => 'password',
    ]);

    $response->assertStatus(200)
        ->assertJson(
            fn (AssertableJson $json) => $json
                ->where('data.user.id', $user->id)
                ->where('data.user.name', $user->name)
                ->where('data.user.email', $user->email)
        )->assertJsonStructure([
            'data' => ['token'],
        ]);
});

test('guest user cannot login with wrong credentials', function ($users) {
    $user = User::factory()->create([
        'email' => 'email@gmail.com',
    ]);

    $response = $this->postJson(route('login'), ['users']);

    $response->assertStatus(422);
})->with([
    [['email' => 'wrong@email.com', 'password' => 'password']],
    [['email' => 'email@gmail.com', 'password' => 'wrong-password']],
]);

test('authenticated user can logout', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->postJson(route('logout'));

    $response->assertStatus(204);
});
