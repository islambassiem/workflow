<?php

namespace Database\Factories;

use App\Enums\Status;
use App\Models\User;
use App\Models\WorkflowRequest;
use App\Models\WorkflowStep;
use Illuminate\Database\Eloquent\Factories\Factory;
use Spatie\Permission\Models\Role;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WorkflowRequestStep>
 */
class WorkflowRequestStepFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'workflow_request_id' => WorkflowRequest::inRandomOrder()->first()->id,
            'workflow_step_id' => WorkflowStep::inRandomOrder()->first()->id,
            'order' => fake()->numberBetween(1, 10),
            'role_id' => Role::inRandomOrder()->first()->id,
            'action_by' => User::inRandomOrder()->first()->id,
            'status' => Status::PENDING->value,
            'comment' => fake()->sentences(asText: true),
            'approved_at' => fake()->dateTime(),
            'rejected_at' => fake()->dateTime(),
        ];
    }
}
