<?php

namespace Database\Seeders;

use App\Models\WorkflowRequest;
use Illuminate\Database\Seeder;

class WorkflowRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WorkflowRequest::factory(10)->create();
    }
}
