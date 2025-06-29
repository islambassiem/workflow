<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $roles = [
            'admin' => 'ادمن',
            'head' => 'رئيس قسم',
            'hr' => 'موارد بشرية',
            'finance' => 'مالية',
            'procurment' => 'مشتريات',
        ];

        foreach ($roles as $role => $role_ar) {
            Role::create([
                'name' => $role,
                'name_ar' => $role_ar,
                'guard_name' => 'sanctum',
            ]);
        }
    }
}
