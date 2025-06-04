<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
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

        $adminUser = User::where('name', 'admin')->first();
        $headUser = User::where('name', 'head')->first();
        $admin = Role::create(['name' => 'admin']);
        $head = Role::create(['name' => 'head']);
        $finance = Role::create(['name' => 'finance']);
        User::find(3)->assignRole($head->name);
        $adminUser->assignRole($admin->name);
        $headUser->assignRole($head->name);

        foreach (User::where('id', '>=', '4')->get() as $user) {
            $user->assignRole($finance->name);
        }

        $this->call([
            WorkflowSeeder::class,
            WorkflowStepSeeder::class,
            WorkflowRequestSeeder::class,
            WorkflowRequestStepSeeder::class,
        ]);

        $this->call([
            WorkflowPermissionSeeder::class,
            WorkflowStepPermissionSeeder::class,
        ]);
    }
}
