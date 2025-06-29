<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'view_any_role',
            'create_a_role',
            'update_a_role',
            'delete_a_role',
            'view_a_role',
        ];

        $role = Role::where('name', 'admin')->first();

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'sanctum']);
            $role->givePermissionTo($permission);
        }
    }
}
