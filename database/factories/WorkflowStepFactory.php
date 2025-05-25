<?php

namespace Database\Factories;

use App\Enums\Approver;
use App\Models\User;
use App\Models\Workflow;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            'workflow_id' => Workflow::inRandomOrder()->first()->id,
            'name' => fake()->text(50),
            'description' => fake()->text(),
            'order' => fake()->numberBetween(1, 10),
            'approver_type' => fake()->randomElement(Approver::class),
            'approver_id' => fake()->randomElement([1, 2]),
            'created_by' => User::inRandomOrder()->first()->id,
            'updated_by' => User::inRandomOrder()->first()->id,
        ];
    }
}
