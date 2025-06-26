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
        Role::create(['name' => 'admin', 'name_ar' => 'أدمن']);
        Role::create(['name' => 'head', 'name_ar' => 'رئيس قسم']);
        Role::create(['name' => 'hr', 'name_ar' => 'موارد بشرية']);
        Role::create(['name' => 'finance', 'name_ar' => 'مالية']);
        Role::create(['name' => 'procurment', 'name_ar' => 'مشتريات']);
    }
}
