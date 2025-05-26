<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class WorkflowPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'view_any_workflow',
            'view_a_workflow',
            'create_a_workflow',
            'update_a_workflow',
        ];

        $role = Role::where('name', 'admin')->first();

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
            $role->givePermissionTo($permission);
        }
    }
}
