<?php

namespace Database\Seeders;

use App\Models\WorkflowRequestStep;
use Illuminate\Database\Seeder;

class WorkflowRequestStepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WorkflowRequestStep::factory(10)->create();
    }
}
