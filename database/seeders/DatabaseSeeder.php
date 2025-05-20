<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);

        $user = User::where('name', 'admin')->first();
        $role = Role::create(['name' => 'admin']);
        $user->assignRole($role->name);

        $this->call([
            WorkflowSeeder::class,
        ]);

        $this->call([
            WorkflowPermissionSeeder::class,
        ]);
    }
}
