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
        Role::create(['name' => 'Admin', 'name_ar' => 'أدمن']);
        Role::create(['name' => 'Head', 'name_ar' => 'رئيس قسم']);
        Role::create(['name' => 'HR', 'name_ar' => 'موارد بشرية']);
        Role::create(['name' => 'Finance', 'name_ar' => 'مالية']);
        Role::create(['name' => 'Procurment', 'name_ar' => 'مشتريات']);
    }
}
