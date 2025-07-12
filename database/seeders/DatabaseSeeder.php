<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([UserSeeder::class, RoleSeeder::class]);

        $adminUser = User::where('name', 'admin')->first();
        $headUser = User::where('name', 'head')->first();
        $hrUser = User::where('name', 'hr')->first();
        $financeUser = User::where('name', 'finance')->first();
        $procurmentUser = User::where('name', 'procurment')->first();
        $ittUser = User::where('name', 'it')->first();

        User::find(3)->assignRole('head');
        $adminUser->assignRole('admin');
        $headUser->assignRole('head');
        $hrUser->assignRole('hr');
        $financeUser->assignRole('finance');
        $procurmentUser->assignRole('procurment');

        $this->call([
            WorkflowSeeder::class,
            WorkflowStepSeeder::class,
            WorkflowRequestSeeder::class,
            WorkflowRequestStepSeeder::class,
        ]);

        $this->call([
            WorkflowPermissionSeeder::class,
            WorkflowStepPermissionSeeder::class,
            RolePermissionSeeder::class,
            PermissionPermissionSeeder::class,
            UserPermissionSeeder::class,
        ]);
    }
}
