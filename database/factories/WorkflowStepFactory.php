<?php

namespace Database\Factories;

use App\Enums\Approver;
use App\Models\User;
use App\Models\Workflow;
use Illuminate\Database\Eloquent\Factories\Factory;
use Spatie\Permission\Models\Role;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WorkflowStep>
 */
class WorkflowStepFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user_id = User::inRandomOrder()->first()->id;
        $type = fake()->randomElement(Approver::class);
        $id = $type->name == 'ROLE' ? Role::inRandomOrder()->first()->id : $user_id;

        return [
            'workflow_id' => Workflow::inRandomOrder()->first()->id,
            'name' => fake()->text(50),
            'description' => fake()->text(),
            'order' => fake()->numberBetween(1, 10),
            'approver_type' => $type,
            'approver_id' => $id,
            'created_by' => $user_id,
            'updated_by' => $user_id,
        ];
    }
}
