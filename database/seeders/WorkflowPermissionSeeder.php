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
        $role = Role::where('name', 'admin')->first();

        Permission::create(['name' => 'view_any_workflow']);
        Permission::create(['name' => 'view_workflow']);
        Permission::create(['name' => 'create_workflow']);
        Permission::create(['name' => 'update_workflow']);

        $role->givePermissionTo('view_any_workflow');
        $role->givePermissionTo('view_workflow');
        $role->givePermissionTo('create_workflow');
        $role->givePermissionTo('update_workflow');
    }
}
