<?php

namespace Database\Factories;

use App\Enums\Priority;
use App\Enums\Status;
use App\Models\User;
use App\Models\Workflow;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WorkflowRequest>
 */
class WorkflowRequestFactory extends Factory
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
            'user_id' => User::inRandomOrder()->first()->id,
            'status' => fake()->randomElement(Status::class),
            'priority' => fake()->randomElement(Priority::class),
            'data' => json_encode([
                'name' => fake()->name(),
                'email' => fake()->email(),
                'address' => fake()->address(),
                'iban' => fake()->iban(),
            ]),
        ];
    }
}
