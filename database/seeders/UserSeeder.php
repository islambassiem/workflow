<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'head_id' => 1,
        ]);

        User::factory()->create([
            'name' => 'head',
            'email' => 'head@example.com',
            'head_id' => 1,
        ]);

        User::factory()->create([
            'name' => 'hr',
            'email' => 'hr@example.com',
            'head_id' => 2,
        ]);

        User::factory()->create([
            'name' => 'finance',
            'email' => 'finance@example.com',
            'head_id' => 2,
        ]);

        User::factory()->create([
            'name' => 'procurment',
            'email' => 'procurment@example.com',
            'head_id' => 2,
        ]);

        User::factory()->create([
            'name' => 'it',
            'email' => 'it@example.com',
            'head_id' => 2,
        ]);

        User::factory()->create([
            'name' => 'user',
            'email' => 'user@example.com',
            'head_id' => 2,
        ]);

        User::factory(7)->create();
    }
}
