<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ApprovalPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::where('name', 'admin')->first();

        $permissions = [
            'view_any_approval',
            'view_approval',
            'create_approval',
            'update_approval',
            'delete_approval',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
            $role->givePermissionTo($permission);
        }
    }
}
