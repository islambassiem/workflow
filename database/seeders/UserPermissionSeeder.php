<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'view_any_user',
            'update_a_user',
        ];

        $role = Role::where('name', 'admin')->first();

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'sanctum']);
            $role->givePermissionTo($permission);
        }
    }
}
