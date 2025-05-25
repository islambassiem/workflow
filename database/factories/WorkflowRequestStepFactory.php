<?php

namespace Database\Factories;

use App\Enums\Status;
use App\Models\User;
use App\Models\WorkflowRequest;
use App\Models\WorkflowStep;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'approver_id' => User::inRandomOrder()->first()->id,
            'status' => fake()->randomElement(Status::class),
            'comment' => fake()->sentences(asText: true),
            'approved_at' => fake()->dateTime(),
            'rejected_at' => fake()->dateTime(),
        ];
    }
}
